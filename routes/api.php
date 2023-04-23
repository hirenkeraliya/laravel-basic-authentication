<?php

use App\Http\Controllers\Api\Auth\SecondUserController;
use Illuminate\Support\Facades\Route;

Route::post('register', [SecondUserController::class, 'register']);
Route::post('login', [SecondUserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('get-user-details', [SecondUserController::class, 'getUserDetails']);

    Route::post('logout', [SecondUserController::class, 'logout']);
});
