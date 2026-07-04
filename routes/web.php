<?php

use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', fn() => redirect()->route('login'));
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('suppliers', App\Http\Controllers\Admin\SupplierController::class);
    Route::resource('products', App\Http\Controllers\Admin\ProductController::class);
});

// Manager routes
Route::prefix('manager')->name('manager.')->middleware(['auth', 'role:Manajer Gudang'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Manager\DashboardController::class, 'index'])->name('dashboard');
});

// Staff routes
Route::prefix('staff')->name('staff.')->middleware(['auth', 'role:Staff Gudang'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Staff\DashboardController::class, 'index'])->name('dashboard');
});