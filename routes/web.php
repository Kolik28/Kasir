<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\StokmasukController;
use App\Http\Controllers\KategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('dashboard', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $multirole = Auth::user()->role === 'admin' ? 'dashboard.admin' : 'transaksi';
    return redirect()->route($multirole);
})->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi');
    Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/transaksi/history', [TransaksiController::class, 'history'])->name('transaksi.history');
    Route::get('/transaksi/print/{id}', [TransaksiController::class, 'printReceipt'])->name('transaksi.print');
    Route::get('/transaksi/{id}', [TransaksiController::class, 'show'])->name('transaksi.show');
    
    Route::prefix('admin')->middleware('check_role:admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.admin');

        Route::get('/produk', [ProdukController::class, 'index'])->name('produk');
        Route::get('/produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
        Route::put('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
        Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
        Route::delete('/produk/{id}/delete', [ProdukController::class, 'destroy'])->name('produk.destroy');
        Route::get('/produk/{id}', [ProdukController::class, 'show'])->name('produk.show');
        
        Route::get('/kategori', [KategoryController::class, 'index'])->name('kategori');
        Route::post('/kategori', [KategoryController::class, 'store'])->name('kategori.store');
        Route::get('/kategori/{id}/edit', [KategoryController::class, 'edit'])->name('kategori.edit');
        Route::put('/kategori/{id}', [KategoryController::class, 'update'])->name('kategori.update');
        Route::delete('/kategori/{id}/delete', [KategoryController::class, 'destroy'])->name('kategori.destroy');

        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
        Route::get('/laporan/print', [LaporanController::class, 'print'])->name('laporan.print');

        Route::get('/user', [UserController::class, 'index'])->name('user');
        Route::post('/user', [UserController::class, 'store'])->name('user.store');
        Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/user/{id}/delete', [UserController::class, 'destroy'])->name('user.destroy');

        Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier');
        Route::post('/supplier', [SupplierController::class, 'store'])->name('supplier.store');
        Route::get('/supplier/{id}/edit', [SupplierController::class, 'edit'])->name('supplier.edit');
        Route::put('/supplier/{id}', [SupplierController::class, 'update'])->name('supplier.update');
        Route::delete('/supplier/{id}/delete', [SupplierController::class, 'destroy'])->name('supplier.destroy');

        Route::get('/stokmasuk', [StokmasukController::class, 'index'])->name('stokmasuk');
        Route::post('/stokmasuk', [StokmasukController::class, 'store'])->name('stokmasuk.store');
    });
});

require __DIR__.'/auth.php';
