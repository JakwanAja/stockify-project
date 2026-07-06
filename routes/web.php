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
    Route::resource('users', App\Http\Controllers\Admin\UserController::class)
    ->only(['index', 'store', 'update', 'destroy']);
});

// Manager routes
Route::prefix('manager')->name('manager.')->middleware(['auth', 'role:Manajer Gudang'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Manager\DashboardController::class, 'index'])->name('dashboard');
       Route::get('/transaksi-masuk', [App\Http\Controllers\Manager\TransaksiMasukController::class, 'index'])->name('transaksi-masuk.index');
       Route::post('/transaksi-masuk/{id}/konfirmasi', [App\Http\Controllers\Manager\TransaksiMasukController::class, 'konfirmasi'])->name('transaksi-masuk.konfirmasi');
       Route::post('/transaksi-masuk/{id}/tolak', [App\Http\Controllers\Manager\TransaksiMasukController::class, 'tolak'])->name('transaksi-masuk.tolak');
});

// Staff routes
Route::prefix('staff')->name('staff.')->middleware(['auth', 'role:Staff Gudang'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Staff\DashboardController::class, 'index'])->name('dashboard');
      Route::get('/transaksi-masuk', [App\Http\Controllers\Staff\TransaksiMasukController::class, 'index'])->name('transaksi-masuk.index');
      Route::post('/transaksi-masuk', [App\Http\Controllers\Staff\TransaksiMasukController::class, 'store'])->name('transaksi-masuk.store');
});
