<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\GetUsersRequest;
use App\Http\Resources\UsersListResource;
use App\Models\User;
use App\Services\ImageProcessingService;

class UserController extends Controller
{
    function listUsers(GetUsersRequest $request)
    {
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
    }

    function createUser(CreateUserRequest $request, ImageProcessingService $imageProcessingService)
    {
        // Image compression and resizing
        $photo = $imageProcessingService->optimizeImage($request->file('photo'));

        $user = new User([
            "name" => $request->input('name'),
            "email" => $request->input('email'),
            "phone" => $request->input('phone'),
            "position_id" => $request->input('position_id'),
            "photo" => $photo
        ]);

        $user->save();

        return response()->json([
            'success' => true,
            'user_id' => $user->id,
            'message' => 'New user successfully registered'
        ]);
    }
}
