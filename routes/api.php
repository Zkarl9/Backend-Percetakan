<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\AuthController;

// API routes for Produk
Route::prefix('v1')->group(function () {
    // Public: list and detail
    Route::get('/produk', [ProdukController::class, 'apiIndex']);
    Route::get('/produk/{id}', [ProdukController::class, 'apiShow']);

    // Auth routes (login/register) - if you use Sanctum, keep these here
    Route::post('/login', [AuthController::class, 'apiLogin']);
    Route::post('/register', [AuthController::class, 'apiRegister']);

    // Protected product routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/produk', [ProdukController::class, 'apiStore']);
        Route::put('/produk/{id}', [ProdukController::class, 'apiUpdate']);
        Route::delete('/produk/{id}', [ProdukController::class, 'apiDestroy']);
    });
});
