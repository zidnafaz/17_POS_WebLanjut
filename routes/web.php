<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SellingController;
use App\Http\Controllers\SuplierController;
use App\Http\Controllers\AuthController;

Route::get('/', [AuthController::class, 'login'])->name('auth.login');

Route::pattern('id','[0-9e]+');

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class,'logout'])->middleware('auth');

Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register', [AuthController::class, 'postRegister'])->name('postRegister');

// ========================
// Middleware Group (auth)
// ========================
Route::middleware(['auth'])->group(function () {

    // --------------------------
    // Dashboard / Home
    // --------------------------
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // --------------------------
    // User - Only ADM
    // --------------------------
    Route::prefix('user')->middleware('authorize:ADM')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::get('/getUsers', [UserController::class, 'getUsers'])->name('user.getUsers');
        Route::get('/count', [UserController::class, 'countByLevel']);
        Route::get('/tambah', [UserController::class, 'tambah']);
        Route::post('/tambah_simpan', [UserController::class, 'tambah_simpan']);
        Route::get('/ubah/{id}', [UserController::class, 'ubah']);
        Route::put('/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);
        Route::get('/hapus/{id}', [UserController::class, 'hapus']);

        Route::get('/create_ajax', [UserController::class, 'create_ajax'])->name('user.create_ajax');
        Route::post('/store_ajax', [UserController::class, 'store_ajax'])->name('user.store_ajax');
        Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax'])->name('user.edit_ajax');
        Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax'])->name('user.update_ajax');
        Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax'])->name('user.confirm_ajax');
        Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax'])->name('user.delete_ajax');
        Route::get('/{id}/detail_ajax', [UserController::class, 'detail_ajax'])->name('user.detail_ajax');
    });

    // --------------------------
    // Level - ADM, MNG
    // --------------------------
    Route::prefix('level')->middleware('authorize:ADM,MNG')->group(function () {
        Route::get('/', [LevelController::class, 'index'])->name('level.index');
        Route::get('/getLevels', [LevelController::class, 'getLevels'])->name('level.getLevels');
        Route::get('/create_ajax', [LevelController::class, 'create_ajax'])->name('level.create_ajax');
        Route::post('/store_ajax', [LevelController::class, 'store_ajax'])->name('level.store_ajax');
        Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax'])->name('level.edit_ajax');
        Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax'])->name('level.update_ajax');
        Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax'])->name('level.confirm_ajax');
        Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax'])->name('level.delete_ajax');
        Route::get('/{id}/detail_ajax', [LevelController::class, 'detail_ajax'])->name('level.detail_ajax');
    });

    // --------------------------
    // Kategori - ADM, MNG, STF
    // --------------------------
    Route::prefix('kategori')->middleware('authorize:ADM,MNG,STF')->group(function () {
        Route::get('/', [KategoriController::class, 'index'])->name('kategori.index');
        Route::post('/', [KategoriController::class, 'store'])->name('kategori.store');
        Route::get('/create', [KategoriController::class, 'create'])->name('kategori.create');
        Route::get('/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
        Route::put('/{id}', [KategoriController::class, 'update'])->name('kategori.update');
        Route::delete('/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
        Route::get('/ajax', [KategoriController::class, 'ajaxKategori'])->name('kategori.ajax');
        Route::get('/create_ajax', [KategoriController::class, 'create_ajax'])->name('kategori.create_ajax');
        Route::post('/store_ajax', [KategoriController::class, 'store_ajax'])->name('kategori.store_ajax');
        Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax'])->name('kategori.edit_ajax');
        Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax'])->name('kategori.update_ajax');
        Route::get('/{id}/confirm_ajax', [KategoriController::class, 'confirm_ajax'])->name('kategori.confirm_ajax');
        Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax'])->name('kategori.delete_ajax');
        Route::get('/{id}/detail_ajax', [KategoriController::class, 'detail_ajax'])->name('kategori.detail_ajax');
    });

    // --------------------------
    // Suplier - ADM, MNG
    // --------------------------
    Route::prefix('suplier')->middleware('authorize:ADM,MNG')->group(function () {
        Route::get('/', [SuplierController::class, 'index'])->name('suplier.index');
        Route::get('/create_ajax', [SuplierController::class, 'create_ajax'])->name('suplier.create_ajax');
        Route::post('/store_ajax', [SuplierController::class, 'store_ajax'])->name('suplier.store_ajax');
        Route::get('/{id}/edit_ajax', [SuplierController::class, 'edit_ajax'])->name('suplier.edit_ajax');
        Route::put('/{id}/update_ajax', [SuplierController::class, 'update_ajax'])->name('suplier.update_ajax');
        Route::get('/{id}/confirm_ajax', [SuplierController::class, 'confirm_ajax'])->name('suplier.confirm_ajax');
        Route::delete('/{id}/delete_ajax', [SuplierController::class, 'delete_ajax'])->name('suplier.delete_ajax');
        Route::get('/{id}/detail_ajax', [SuplierController::class, 'detail_ajax'])->name('suplier.detail_ajax');
    });

    // --------------------------
    // Products - ADM, MNG, STF
    // --------------------------
    Route::prefix('products')->middleware('authorize:ADM,MNG,STF')->group(function () {
        Route::get('/', [ProductController::class, 'dataTableIndex'])->name('products.index');
        Route::get('/create-ajax', [ProductController::class, 'create_ajax'])->name('products.create_ajax');
        Route::get('/{id}/edit-ajax', [ProductController::class, 'edit_ajax'])->name('products.edit_ajax');
        Route::post('/store_ajax', [ProductController::class, 'store_ajax'])->name('products.store_ajax');
        Route::put('/{id}/update_ajax', [ProductController::class, 'update_ajax'])->name('products.update_ajax');
        Route::get('/{id}/confirm_ajax', [ProductController::class, 'confirm_ajax'])->name('products.confirm_ajax');
        Route::delete('/{id}/delete_ajax', [ProductController::class, 'delete_ajax'])->name('products.delete_ajax');
        Route::get('/{id}/detail_ajax', [ProductController::class, 'detail_ajax'])->name('products.detail_ajax');
    });

    // --------------------------
    // Penjualan - ADM, MNG, STF
    // --------------------------
    Route::get('/penjualan', [SellingController::class, 'index'])
        ->middleware('authorize:ADM,MNG,STF')
        ->name('selling.index');
});
