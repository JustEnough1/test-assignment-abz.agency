<?php

use App\Http\Controllers\PositionController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\ValidateRegistrationToken;
use Illuminate\Support\Facades\Route;

Route::prefix("/v1")->group(function () {
    Route::get('/users', [UserController::class, "listUsers"]);
    Route::get('/users/{id}', [UserController::class, "getUser"]);
    Route::get('/token', [TokenController::class, "generateToken"]);
    Route::get('/positions', [PositionController::class, "listPositions"]);
    Route::post('/users', [UserController::class, "createUser"])->middleware(ValidateRegistrationToken::class);
});
