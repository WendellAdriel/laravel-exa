<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Controllers\AuthController;
use Modules\Auth\Controllers\UserController;
use Modules\Auth\Support\Roles;

// Public Routes
Route::post('auth/login', [AuthController::class, 'login']);

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'user']);
    });

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::post('/', [UserController::class, 'store'])->middleware('role:'.Roles::MANAGER->value);

        Route::prefix('{uuid}')->group(function () {
            Route::get('/', [UserController::class, 'show']);

            Route::middleware('role:'.Roles::MANAGER->value)->group(function () {
                Route::put('/', [UserController::class, 'update']);
                Route::delete('/', [UserController::class, 'destroy']);
            });
        });
    });
});
