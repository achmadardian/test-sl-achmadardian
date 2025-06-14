<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PositionController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [AuthController::class, 'login']);
Route::get('/auth/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// protected routes
Route::middleware('auth:sanctum')->group(function() {
    // positions
    Route::apiResource('positions', PositionController::class);
});
