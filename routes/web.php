<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Change Password Routes
    Route::get('/change-password', [App\Http\Controllers\AuthController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/change-password', [App\Http\Controllers\AuthController::class, 'changePassword']);

    // Admin management routes (Super Admin only)
    Route::middleware(['auth', \App\Http\Middleware\SuperAdminMiddleware::class])->group(function () {
        Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
        Route::get('/admin/create', [App\Http\Controllers\AdminController::class, 'create'])->name('admin.create');
        Route::post('/admin', [App\Http\Controllers\AdminController::class, 'store'])->name('admin.store');
        Route::patch('/admin/{admin}/toggle-status', [App\Http\Controllers\AdminController::class, 'toggleStatus'])
            ->name('admin.toggle-status');
    });
});
