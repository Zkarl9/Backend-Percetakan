<?php
// Backend: routes/api.php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EcommerceController;

Route::prefix('v1')->group(function () {
    // Public routes
    Route::get('/produk', [ProdukController::class, 'apiIndex']);
    Route::get('/produk/{id}', [ProdukController::class, 'apiShow']);
    
    // E-Commerce public endpoint
    Route::get('/ecommerce', [EcommerceController::class, 'apiIndex']);

    // Auth routes
    Route::post('/login', [AuthController::class, 'apiLogin']);
    Route::post('/register', [AuthController::class, 'apiRegister']);

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/produk', [ProdukController::class, 'apiStore']);
        Route::put('/produk/{id}', [ProdukController::class, 'apiUpdate']);
        Route::delete('/produk/{id}', [ProdukController::class, 'apiDestroy']);

        // E-commerce CRUD (protected)
        Route::post('/ecommerce', [EcommerceController::class, 'apiStore']);
        Route::put('/ecommerce/{id}', [EcommerceController::class, 'apiUpdate']);
        Route::delete('/ecommerce/{id}', [EcommerceController::class, 'apiDestroy']);
    });
});

Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toDateTimeString(),
        'service' => 'Backend API',
        'version' => '1.0.0'
    ]);
});