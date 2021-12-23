<?php

use App\Http\Controllers\AnalsisiController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarcodeController;
use App\Http\Controllers\Manajemen\Pengguna\PenggunaController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\GetController;
use App\Http\Controllers\RiwayatController;
use App\Models\Barang;
use App\Models\Riwayat_nota;
use App\Models\Riwayat_pesanan;

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


Route::group(['middleware'=> 'guest'], function() {


    Route::get('/sign_in', [AuthController::class, 'sign_in']);
    Route::post('/sign_in', [AuthController::class, 'post_sign_in'])->name('login');


});

Route::group(['middleware'=> 'auth'], function() {

    Route::get('/', [HomeController::class, 'dashboard'])->name('home');

    Route::get('/sign_out', [AuthController::class, 'sign_out']);

    // PENGGUNA
    Route::get('/manajemen/pengguna', [PenggunaController::class, 'index']);
    Route::post('/manajemen/pengguna/post-tambah-pengguna', [PenggunaController::class, 'post_tambah_pengguna']);
    Route::put('/manajemen/pengguna/post-ubah-pengguna', [PenggunaController::class, 'post_ubah_pengguna']);
    Route::get('/manajemen/pengguna/hapus-pengguna/{id}', [PenggunaController::class, 'hapus_pengguna']);



    // barang
    Route::get('/manajemen/barang/daftar-barang', [BarangController::class, 'daftar_barang']);
    Route::post('/manajemen/barang/daftar-barang/post-tambah-barang', [BarangController::class, 'post_tambah_barang']);
    Route::put('/manajemen/barang/daftar-barang/post-ubah-barang', [BarangController::class, 'post_ubah_barang']);
    Route::get('/manajemen/barang/daftar-barang/hapus-barang/{id}', [BarangController::class, 'hapus_barang']);
    Route::post('/manajemen/barang/daftar-barang/post-stok-barang/{id}', [BarangController::class, 'ubah_stok']);

    Route::get('/penerimaan-barang', [BarangController::class, 'penerimaan_barang']);
    Route::get('/penerimaan-barang/get-daftar-barang', [BarangController::class, 'get_daftar_barang']);
    Route::post('/barang-masuk/post-barang-masuk', [BarangController::class, 'post_barang_masuk']);
    Route::get('/barang-masuk/get_list_barang_masuk', [BarangController::class, 'get_list_barang_masuk']);

    // supplier
    Route::get('/data-supplier', [SupplierController::class, 'data_supplier']);

    // penjualan
    Route::get('/penjualan-barang', [PenjualanController::class, 'penjualan_barang']);
    Route::post('/post-tambah-nota', [PenjualanController::class, 'post_tambah_nota']);
    Route::get('/get-barang', [PenjualanController::class, 'get_barang']);
    Route::get('/get-nota-pesanan/{id}', [PenjualanController::class, 'get_nota_pesanan']);
    Route::get('/penjualan/cari-barang', [PenjualanController::class, 'cari_barang']);
    Route::get('/penjualan/hapus-pesanan/{id}', [PenjualanController::class, 'hapus_pesanan']);
    Route::post('/penjualan/ubah-jumlah-pesanan', [PenjualanController::class, 'ubah_jumlah_pesanan']);
    Route::get('/checkout-nota/{id}', [PenjualanController::class, 'checkout_nota']);
    Route::post('/penjualan/ubah-harga-satuan', [PenjualanController::class, 'ubah_harga_satuan']);
    Route::get('/hapus_nota/{id}', [PenjualanController::class, 'hapus_nota']);

    // GETController
    Route::get('/get-total-harga-nota/{id}', [GetController::class, 'get_total_harga_nota']);
    Route::get('/get-barang/{id}', [GetController::class, 'get_barang']);
    Route::get('/get-pesanan/{id}', [GetController::class, 'get_pesanan']);
    Route::get('/get-pengguna/{id}', [GetController::class, 'get_pengguna']);


    // riwayat
    Route::get('/riwayat-pesanan', [RiwayatController::class, 'riwayat_nota']);
    Route::get('/nota/{id}', [RiwayatController::class, 'nota']);
    Route::get('/batalkan_checkout/{id}', [RiwayatController::class, 'batal_checkout']);
    Route::get('/riwayat-barang-masuk', [RiwayatController::class, 'riwayat_barang_masuk']);

    // Analisi
    Route::get('/analisis-penjualan', [AnalsisiController::class, 'analisis_penjualan']);

    // barcode
    Route::get('/barcode/{kode}', [BarcodeController::class, 'barcode']);
});