<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CitiesController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\Api\AuthController;

Route::post('/validate-token', [AuthController::class, 'validateToken']);

Route::prefix('auth')->group(function () {
    Route::post('register', [UserController::class, 'register']);
    Route::post('login', [UserController::class, 'login']);
    Route::middleware('auth:sanctum')->post('logout', [UserController::class, 'logout']);
});

// User routes
Route::middleware(['auth:sanctum', 'can:admin'])->group(function () {
    Route::resource('users', UserController::class)->except(['create', 'edit']);
});

// Property routes
Route::resource('properties', PropertyController::class)->only(['index', 'show']);
Route::middleware(['auth:sanctum', 'can:admin'])->group(function () {
    Route::resource('properties', PropertyController::class)->only(['store', 'update', 'destroy']);
});

// Category routes
Route::resource('categories', CategoryController::class)->only(['index', 'show']);
Route::middleware(['auth:sanctum', 'can:admin'])->group(function () {
    Route::resource('categories', CategoryController::class)->only(['store', 'update', 'destroy']);
});

// City routes
Route::resource('cities', CitiesController::class)->only(['index', 'show']);
Route::middleware(['auth:sanctum', 'can:admin'])->group(function () {
    Route::resource('cities', CitiesController::class)->only(['store', 'update', 'destroy']);
});

// District routes
Route::resource('districts', DistrictController::class)->only(['index', 'show']);
Route::middleware(['auth:sanctum', 'can:admin'])->group(function () {
    Route::resource('districts', DistrictController::class)->only(['store', 'update', 'destroy']);
});

// State routes
Route::resource('states', StateController::class)->only(['index', 'show']);
Route::middleware(['auth:sanctum', 'can:admin'])->group(function () {
    Route::resource('states', StateController::class)->only(['store', 'update', 'destroy']);
});
