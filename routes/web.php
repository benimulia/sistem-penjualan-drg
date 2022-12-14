<?php


use App\Http\Controllers\RekapBonController;
use App\Http\Controllers\RekapBayarBonController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenjualanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);

    // ================== CABANG ==================
    Route::get('/cabang', [CabangController::class, 'index'])->name('cabang.index');
    Route::get('/cabang/create', [CabangController::class, 'create'])->name('cabang.create');
    Route::post('/cabang/store', [CabangController::class, 'store'])->name('cabang.store');
    Route::get('/cabang/edit/{id}', [CabangController::class, 'edit'])->name('cabang.edit');
    Route::post('/cabang/update/{id}', [CabangController::class, 'update'])->name('cabang.update');
    Route::get('/cabang/delete/{id}', [CabangController::class, 'destroy'])->name('cabang.destroy');

    // ================== PELANGGAN ==================
    Route::get('/pelanggan', [PelangganController::class, 'index'])->name('pelanggan.index');
    Route::get('/pelanggan/create', [PelangganController::class, 'create'])->name('pelanggan.create');
    Route::post('/pelanggan/store', [PelangganController::class, 'store'])->name('pelanggan.store');
    Route::get('/pelanggan/edit/{id}', [PelangganController::class, 'edit'])->name('pelanggan.edit');
    Route::post('/pelanggan/update/{id}', [PelangganController::class, 'update'])->name('pelanggan.update');
    Route::get('/pelanggan/delete/{id}', [PelangganController::class, 'destroy'])->name('pelanggan.destroy');

    // ================== PRODUK ==================
    Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
    Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
    Route::post('/produk/store', [ProdukController::class, 'store'])->name('produk.store');
    Route::get('/produk/edit/{id}', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::post('/produk/update/{id}', [ProdukController::class, 'update'])->name('produk.update');
    Route::get('/produk/delete/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');

    // ================== PEMBELIAN ==================
    Route::get('/pembelian', [PembelianController::class, 'index'])->name('pembelian.index');
    Route::get('/pembelian/create', [PembelianController::class, 'create'])->name('pembelian.create');
    Route::post('/pembelian/store', [PembelianController::class, 'store'])->name('pembelian.store');
    Route::get('/pembelian/edit/{id}', [PembelianController::class, 'edit'])->name('pembelian.edit');
    Route::get('/pembelian/delete/{id}', [PembelianController::class, 'destroy'])->name('pembelian.destroy');

    // ================== PENJUALAN ==================
    Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan.index');
    Route::get('/penjualan/create', [PenjualanController::class, 'create'])->name('penjualan.create');
    Route::post('/penjualan/store', [PenjualanController::class, 'store'])->name('penjualan.store');
    Route::get('/penjualan/edit/{id}', [PenjualanController::class, 'edit'])->name('penjualan.edit');
    Route::get('/penjualan/delete/{id}', [PenjualanController::class, 'destroy'])->name('penjualan.destroy');

    Route::post('/penjualan/fetch', [PenjualanController::class, 'fetch'])->name('penjualan.fetch');

    // ================== REKAP BON ==================
    Route::get('/rekapbon', [RekapBonController::class, 'index'])->name('rekapbon.index');
    Route::get('/rekapbon/create', [RekapBonController::class, 'create'])->name('rekapbon.create');
    Route::post('/rekapbon/store', [RekapBonController::class, 'store'])->name('rekapbon.store');
    Route::get('/rekapbon/edit/{id}', [RekapBonController::class, 'edit'])->name('rekapbon.edit');
    Route::post('/rekapbon/update/{id}', [RekapBonController::class, 'update'])->name('rekapbon.update');
    Route::get('/rekapbon/delete/{id}', [RekapBonController::class, 'destroy'])->name('rekapbon.destroy');

    // ================== REKAP BAYAR BON ==================
    Route::get('/rekapbayarbon', [RekapBayarBonController::class, 'index'])->name('rekapbayarbon.index');
    Route::get('/rekapbayarbon/create/{id}', [RekapBayarBonController::class, 'create'])->name('rekapbayarbon.create');
    Route::post('/rekapbayarbon/store/{id}', [RekapBayarBonController::class, 'store'])->name('rekapbayarbon.store');
    Route::get('/rekapbayarbon/edit/{id}', [RekapBayarBonController::class, 'edit'])->name('rekapbayarbon.edit');
    Route::post('/rekapbayarbon/update/{id}', [RekapBayarBonController::class, 'update'])->name('rekapbayarbon.update');
    Route::get('/rekapbayarbon/delete/{id}', [RekapBayarBonController::class, 'destroy'])->name('rekapbayarbon.destroy');
});