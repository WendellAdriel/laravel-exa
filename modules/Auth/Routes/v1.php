<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Auth\Controllers\AuthController;
use Modules\Auth\Controllers\UserController;
use Modules\Auth\Support\Role;

// Public Routes
Route::post('auth/login', [AuthController::class, 'login']);

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::get('auth/me', [AuthController::class, 'user']);

    Route::get('users', [UserController::class, 'index']);
    Route::get('users/{uuid}', [UserController::class, 'show']);

    Route::middleware('has_role:' . Role::MANAGER->value)->group(function () {
        Route::post('users', [UserController::class, 'store']);
        Route::put('users/{uuid}', [UserController::class, 'update']);
        Route::delete('users/{uuid}', [UserController::class, 'destroy']);
    });
});
