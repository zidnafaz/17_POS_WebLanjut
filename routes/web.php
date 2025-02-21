<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SellingController;

// Route Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Route Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/category/{category}', [ProductController::class, 'show'])->name('products.category');

// Route User
Route::get('/user/{id}/name/{name}', [UserController::class, 'show'])->name('user.show');

// Route Penjualan (Selling)
Route::get('/penjualan', [SellingController::class, 'index'])->name('selling.index');
