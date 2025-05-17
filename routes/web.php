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

Route::pattern('id', '[0-9e]+');

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');

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

    Route::get('/profile/{id}', [UserController::class, 'profile'])->name('user.profile');
    Route::put('/profile/{id}', [UserController::class, 'updateProfile'])->name('user.update_profile');
    Route::post('/profile/{id}/update', [UserController::class, 'updateProfile'])->name('user.update_profile');

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

        // Import and Export routes
        Route::get('/import', [UserController::class, 'import'])->name('user.import');
        Route::post('/import_ajax', [UserController::class, 'import_ajax'])->name('user.import_ajax');
        Route::get('/export_excel', [UserController::class, 'export_excel'])->name('user.export_excel');
        Route::get('/export_pdf', [UserController::class, 'export_pdf'])->name('user.export_pdf');
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

        // Import and Export routes
        Route::get('/import', [LevelController::class, 'import'])->name('level.import');
        Route::post('/import_ajax', [LevelController::class, 'import_ajax'])->name('level.import_ajax');
        Route::get('/export_excel', [LevelController::class, 'export_excel'])->name('level.export_excel');
        Route::get('/export_pdf', [LevelController::class, 'export_pdf'])->name('level.export_pdf');
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

        // Import and Export routes
        Route::get('/import', [SuplierController::class, 'import'])->name('suplier.import');
        Route::post('/import_ajax', [SuplierController::class, 'import_ajax'])->name('suplier.import_ajax');
        Route::get('/export_excel', [SuplierController::class, 'export_excel'])->name('suplier.export_excel');
        Route::get('/export_pdf', [SuplierController::class, 'export_pdf'])->name('suplier.export_pdf');
    });

    // --------------------------
    // Kategori - ADM, MNG, STF
    // --------------------------
    Route::prefix('kategori')->middleware('authorize:ADM,MNG,STF')->group(function () {
        Route::get('/import', [KategoriController::class, 'import'])->name('kategori.import');
        Route::post('/import_ajax', [KategoriController::class, 'import_ajax'])->name('kategori.import_ajax');
        Route::get('/export_excel', [KategoriController::class, 'export_excel'])->name('kategori.export_excel');
        Route::get('/export_pdf', [KategoriController::class, 'export_pdf'])->name('kategori.export_pdf');
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
        Route::get('/import', [ProductController::class, 'import'])->name('products.import');
        Route::post('/import_ajax', [ProductController::class, 'import_ajax'])->name('products.import_ajax');
        Route::get('/export_excel', [ProductController::class, 'export_excel'])->name('products.export_excel');
        Route::get('/export_pdf', [ProductController::class, 'export_pdf'])->name('products.export_pdf');
    });

    // --------------------------
    // Penjualan - ADM, MNG, STF
    // --------------------------
    Route::get('/penjualan', [SellingController::class, 'index'])
        ->middleware('authorize:ADM,MNG,STF')
        ->name('selling.index');
});
