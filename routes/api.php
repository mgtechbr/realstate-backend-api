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

// Grupo de rotas para autenticação
Route::prefix('auth')->group(function () {
    Route::post('register', [UserController::class, 'register']);
    Route::post('login', [UserController::class, 'login']);
    Route::middleware('auth:sanctum')->post('logout', [UserController::class, 'logout']);
});


// Grupo de rotas para usuários com permissão "admin"
Route::middleware(['auth:sanctum', 'can:admin'])->group(function () {
    Route::get('users', [UserController::class, 'index']);                // Listar todos os usuários
    Route::get('users/{id}', [UserController::class, 'show']);            // Detalhar usuário
    Route::post('users', [UserController::class, 'store']);               // Criar novo usuário
    Route::put('users/{id}', [UserController::class, 'update']);          // Atualizar usuário
    Route::delete('users/{id}', [UserController::class, 'destroy']);      // Deletar usuário
});

// Rotas públicas para propriedades (sem autenticação necessária)
Route::get('properties', [PropertyController::class, 'index']);       // Listar todas as propriedades
Route::get('properties/{id}', [PropertyController::class, 'show']);   // Detalhar propriedade

// Grupo de rotas para propriedades com permissão "admin"
Route::middleware(['auth:sanctum', 'can:admin'])->group(function () {
    Route::post('properties', [PropertyController::class, 'store']);      // Criar nova propriedade
    Route::put('properties/{id}', [PropertyController::class, 'update']); // Atualizar propriedade
    Route::delete('properties/{id}', [PropertyController::class, 'destroy']); // Deletar propriedade
});

// Rotas públicas para categorias
Route::get('categories', [CategoryController::class, 'index']);       // Listar todas as categorias
Route::get('categories/{id}', [CategoryController::class, 'show']);   // Detalhar categoria

// Grupo de rotas para categorias com permissão "admin"
Route::middleware(['auth:sanctum', 'can:admin'])->group(function () {
    Route::post('categories', [CategoryController::class, 'store']);      // Criar nova categoria
    Route::put('categories/{id}', [CategoryController::class, 'update']); // Atualizar categoria
    Route::delete('categories/{id}', [CategoryController::class, 'destroy']); // Deletar categoria
});

// Rotas públicas para cidades
Route::get('cities', [CitiesController::class, 'index']);       // Listar todas as cidades
Route::get('cities/{id}', [CitiesController::class, 'show']);   // Detalhar cidade

// Grupo de rotas para cidades com permissão "admin"
Route::middleware(['auth:sanctum', 'can:admin'])->group(function () {
    Route::post('cities', [CitiesController::class, 'store']);      // Criar nova cidade
    Route::put('cities/{id}', [CitiesController::class, 'update']); // Atualizar cidade
    Route::delete('cities/{id}', [CitiesController::class, 'destroy']); // Deletar cidade
});

// Rotas públicas para bairros (districts)
Route::get('district', [DistrictController::class, 'index']);       // Listar todos os bairros
Route::get('district/{id}', [DistrictController::class, 'show']);   // Detalhar bairro

// Grupo de rotas para bairros com permissão "admin"
Route::middleware(['auth:sanctum', 'can:admin'])->group(function () {
    Route::post('district', [DistrictController::class, 'store']);      // Criar novo bairro
    Route::put('district/{id}', [DistrictController::class, 'update']); // Atualizar bairro
    Route::delete('district/{id}', [DistrictController::class, 'destroy']); // Deletar bairro
});

// Rotas públicas para estados
Route::get('state', [StateController::class, 'index']);       // Listar todos os estados
Route::get('state/{id}', [StateController::class, 'show']);   // Detalhar estado

// Grupo de rotas para estados com permissão "admin"
Route::middleware(['auth:sanctum', 'can:admin'])->group(function () {
    Route::post('state', [StateController::class, 'store']);      // Criar novo estado
    Route::put('state/{id}', [StateController::class, 'update']); // Atualizar estado
    Route::delete('state/{id}', [StateController::class, 'destroy']); // Deletar estado
});
