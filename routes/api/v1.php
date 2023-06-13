<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    // USER Routes
    Route::prefix('auth')->group(function () {
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/register', [AuthController::class, 'register']);
    });

    Route::middleware('auth:sanctum')->group(function () {
        // USER Routes
        Route::prefix('user')->group(function () {
            Route::get('/', [UserController::class, 'user']);
        });

        // Team Routes
        Route::prefix('team')->group(function () {
            Route::get('/', [TeamController::class, 'info']);
            Route::patch('/{id}', [TeamController::class, 'update']);
        });

        // Country Routes
        Route::prefix('countries')->group(function () {
            Route::get('/', [CountryController::class, 'findItems']);
        });

        // Transfer Routes
        Route::prefix('transfers')->group(function () {
            Route::get('/', [TransferController::class, 'findItems']);
            Route::post('/sell', [TransferController::class, 'sellPlayers']);
            Route::post('/buy', [TransferController::class, 'buyPlayers']);
        });
    });
});
