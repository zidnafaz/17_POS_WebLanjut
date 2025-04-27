<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SellingController;

// Route Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Route Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/category/{category}', [ProductController::class, 'show'])->name('products.category');

// Route Penjualan (Selling)
Route::get('/penjualan', [SellingController::class, 'index'])->name('selling.index');

// Route Level
Route::prefix('level')->group(function () {
    Route::get('/', [LevelController::class, 'index']);
    Route::get('/getLevels', [LevelController::class, 'getLevels'])->name('level.getLevels');

    Route::get('/create_ajax', [LevelController::class, 'create_ajax'])->name('level.create_ajax');
    Route::post('/store_ajax', [LevelController::class, 'store_ajax'])->name('level.store_ajax');

    Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax'])->name('level.edit_ajax');
    Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax'])->name('level.update_ajax');

    Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax'])->name('level.confirm_ajax');
    Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax'])->name('level.delete_ajax');
});

// Route Kategori
Route::prefix('kategori')->group(function () {
    Route::get('/', [KategoriController::class, 'index'])->name('kategori.index');
    Route::post('/', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/create', [KategoriController::class, 'create'])->name('kategori.create');
    Route::get('/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/{id}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
});

// Route User
Route::prefix('user')->group(function () {
    // Main user route
    Route::get('/', [UserController::class, 'index']);
    Route::get('/getUsers', [UserController::class, 'getUsers'])->name('user.getUsers');

    // User count route
    Route::get('/count', [UserController::class, 'countByLevel']);

    // Add user routes
    Route::get('/tambah', [UserController::class, 'tambah']);
    Route::post('/tambah_simpan', [UserController::class, 'tambah_simpan']);

    // Edit user routes
    Route::get('/ubah/{id}', [UserController::class, 'ubah']);
    Route::put('/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);

    // Delete user route
    Route::get('/hapus/{id}', [UserController::class, 'hapus']);

    // Ajax Route
    Route::get('/create_ajax', [UserController::class, 'create_ajax'])->name('user.create_ajax');
    Route::post('/store_ajax', [UserController::class, 'store_ajax'])->name('user.store_ajax');

    // Ajax Edit
    Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax'])->name('user.edit_ajax');
    Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax'])->name('user.update_ajax');

    // Ajax Delete
    Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax'])->name('user.confirm_ajax');
    Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax'])->name('user.delete_ajax');
});
