<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;

    //Rute login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    //Rute transaksi
    // Export route harus didefinisikan sebelum resource agar tidak tertangkap parameter {transaksi}
    Route::get('transaksi/export', [TransaksiController::class, 'export'])->name('transaksi.export');
    Route::resource('transaksi', TransaksiController::class);
    Route::get('transaksi/{transaksi}/invoice', [TransaksiController::class, 'viewInvoice'])->name('transaksi.view-invoice');
    Route::get('transaksi/{transaksi}/download-invoice', [TransaksiController::class, 'downloadInvoice'])->name('transaksi.download-invoice');

    //Rute produk
    Route::resource('produk', ProdukController::class);

    //Rute pelanggan
    Route::resource('customers', CustomerController::class);

    // Rute kategori
    Route::get('kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::post('kategori', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('kategori/{kategori}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('kategori/{kategori}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('kategori/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');