<?php

use App\Http\Controllers\Api\Auth\UserController;
use Illuminate\Support\Facades\Route;

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('get-user-details', [UserController::class, 'getUserDetails']);

    Route::post('logout', [UserController::class, 'logout']);
});
