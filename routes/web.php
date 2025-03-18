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

// Route User
// Route::get('/user/{id}/name/{name}', [UserController::class, 'show'])->name('user.show');

// Route Penjualan (Selling)
Route::get('/penjualan', [SellingController::class, 'index'])->name('selling.index');

// Route Level
Route::get('/Level', [LevelController::class, 'index']);

// Route Kategori
Route::get('/kategori', [KategoriController::class, 'index']);
Route::post('/kategori', [KategoriController::class, 'store']);
Route::get('/kategori/create', [KategoriController::class, 'create']);
Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');
Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

// ORM
Route::get('/user', [UserController::class, 'index']);

// Route user_count
Route::get('/user_count', [UserController::class, 'countByLevel']);

// Route Tambah User
Route::get('/user/tambah', [UserController::class, 'tambah']);
Route::post('/user/tambah_simpan', [UserController::class, 'tambah_simpan']);

// Route Ubah Data User
Route::get('/user/ubah/{id}', [UserController::class, 'ubah']);
Route::put('/user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);

// Route Untuk Delete User
Route::get('/user/hapus/{id}', [UserController::class, 'hapus']);
