<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\Manajemen\Pengguna\PenggunaController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PenjualanController;
use App\Models\Barang;

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

    Route::get('/manajemen/pengguna', [PenggunaController::class, 'index']);

    // barang
    Route::get('/daftar_barang', [BarangController::class, 'daftar_barang']);
    Route::post('/post-tambah-barang', [BarangController::class, 'post_tambah_barang']);
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

});