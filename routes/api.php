<?php

use App\Http\Requests\UsersRequest;
use App\Http\Resources\UsersListResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::prefix("/v1")->group(function () {
    Route::get('/users', function (UsersRequest $request) {

        $perPage = $request->input('count', 6);
        $currentPage = $request->input('page', 1);

        $paginator = User::with('position')->paginate($perPage);

        // Check if page exists
        if ($currentPage > $paginator->lastPage()) {
            return response()->json([
                'success' => false,
                'message' => 'Page not found',
            ], 404);
        }

        return new UsersListResource($paginator);
    });
});
