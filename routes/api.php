<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// Public Route
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);



// Protected Route
Route::middleware(['auth:sanctum'])->group(function() {
Route::post('/logout', [UserController::class, 'logout']);

});
