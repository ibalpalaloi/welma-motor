<?php

use App\Http\Controllers\AnalsisiController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;

use App\Http\Controllers\Manajemen\Barang\BarangController;
use App\Http\Controllers\Manajemen\Barang\BarcodeController;
use App\Http\Controllers\Manajemen\Pengguna\PenggunaController;
use App\Http\Controllers\Manajemen\Supplier\SupplierController;
use App\Http\Controllers\Manajemen\Montir\MontirController;

use App\Http\Controllers\Penjualan\PenjualanController;
use App\Http\Controllers\Penjualan\RiwayatController;
use App\Http\Controllers\Penjualan\AnalisisController;



use App\Http\Controllers\GetController;
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
Route::get('/sign_out', [AuthController::class, 'sign_out']);



// GETController
Route::get('/get-total-harga-nota/{id}', [GetController::class, 'get_total_harga_nota']);
Route::get('/get-barang/{id}', [GetController::class, 'get_barang']);
Route::get('/get-pesanan/{id}', [GetController::class, 'get_pesanan']);
Route::get('/get-pengguna/{id}', [GetController::class, 'get_pengguna']);
Route::get('/get-supplier/{id}', [GetController::class, 'get_supplier']);
Route::get('/autocode_kode_barang', [GetController::class, 'autocode_kode_barang']);

Route::group(['middleware'=> ['auth', 'checkRole:Kasir,Admin']], function() {

    Route::get('/', [HomeController::class, 'dashboard'])->name('home');
    Route::post('/ubah_password', [AuthController::class, 'ganti_password']);

    // penjualan
    Route::get('/penjualan', [PenjualanController::class, 'penjualan_barang']);
    Route::post('/penjualan/post-tambah-nota', [PenjualanController::class, 'post_tambah_nota']);
    Route::get('/penjualan/get-barang', [PenjualanController::class, 'get_barang']);
    Route::get('/get-nota-pesanan/{id}', [PenjualanController::class, 'get_nota_pesanan']);
    Route::get('/penjualan/cari-barang', [PenjualanController::class, 'cari_barang']);
    Route::post('/pesanan/tambah_pesanan', [PenggunaController::class, 'tambah_pesanan']);
    Route::get('/penjualan/hapus-pesanan/{id}', [PenjualanController::class, 'hapus_pesanan']);
    Route::post('/penjualan/ubah-jumlah-pesanan', [PenjualanController::class, 'ubah_jumlah_pesanan']);
    Route::get('/checkout-nota/{id}', [PenjualanController::class, 'checkout_nota']);
    Route::post('/penjualan/ubah-harga-satuan', [PenjualanController::class, 'ubah_harga_satuan']);
    Route::get('/hapus_nota/{id}', [PenjualanController::class, 'hapus_nota']);
    Route::post('/penjualan-ubah-montir', [PenjualanController::class, 'ubah_montir']);
    Route::post('/penjualan/ubah-nama-jasa', [PenjualanController::class, 'ubah_nama_jasa']);

    // BARANG

    Route::get('/manajemen/barang/daftar-barang', [BarangController::class, 'daftar_barang']);


    // NOTA
    Route::get('/nota/{jenis}/{id}', [RiwayatController::class, 'nota']);
    Route::get('/download_nota/{id}', [RiwayatController::class, 'download_nota']);

    // riwayat
    Route::get('/riwayat-pesanan', [RiwayatController::class, 'riwayat_nota']);
    Route::get('/load-riwayat-nota', [RiwayatController::class, 'load_riwayat_nota']);
    Route::get('/batalkan_checkout/{id}', [RiwayatController::class, 'batal_checkout']);

    Route::get('/riwayat-nota-tgl', [RiwayatController::class, 'riwayat_nota_tgl']);
});

Route::group(['middleware'=> ['auth', 'checkRole:Admin']], function() {


    // PENGGUNA
    Route::get('/manajemen/pengguna', [PenggunaController::class, 'index']);
    Route::post('/manajemen/pengguna/post-tambah-pengguna', [PenggunaController::class, 'post_tambah_pengguna']);
    Route::put('/manajemen/pengguna/post-ubah-pengguna', [PenggunaController::class, 'post_ubah_pengguna']);
    Route::get('/manajemen/pengguna/hapus-pengguna/{id}', [PenggunaController::class, 'hapus_pengguna']);

    // BARANG
    // DAFTAR BARANG
    Route::get('/manajemen/barang/daftar-barang', [BarangController::class, 'daftar_barang']);
    Route::post('/manajemen/barang/daftar-barang/post-tambah-barang', [BarangController::class, 'post_tambah_barang']);
    Route::put('/manajemen/barang/daftar-barang/post-ubah-barang', [BarangController::class, 'post_ubah_barang']);
    Route::get('/manajemen/barang/daftar-barang/hapus-barang/{id}', [BarangController::class, 'hapus_barang']);
    Route::post('/manajemen/barang/daftar-barang/post-stok-barang/{id}', [BarangController::class, 'ubah_stok']);

    // PENERIMAAN
    Route::get('/manajemen/barang/penerimaan-barang', [BarangController::class, 'penerimaan_barang']);
    Route::get('/manajemen/barang/penerimaan-barang/get-daftar-barang', [BarangController::class, 'get_daftar_barang']);
    Route::post('/manajemen/barang/penerimaan-barang/post-barang-masuk', [BarangController::class, 'post_barang_masuk']);
    Route::get('/manajemen/barang/penerimaan-barang/get-list-barang-masuk', [BarangController::class, 'get_list_barang_masuk']);


    // supplier
    Route::get('/manajemen/supplier/data-supplier', [SupplierController::class, 'data_supplier']);
    Route::post('/manajemen/supplier/post-tambah-supplier', [SupplierController::class, 'post_supplier_baru']);
    Route::post('/manajemen/supplier/post-ubah-supplier', [SupplierController::class, 'post_ubah_supplier']);
    Route::get('/manajemen/supplier/hapus-supplier/{id}', [SupplierController::class, 'hapus_supplier']);

    // // penjualan
    // Route::get('/penjualan', [PenjualanController::class, 'penjualan_barang']);
    // Route::post('/penjualan/post-tambah-nota', [PenjualanController::class, 'post_tambah_nota']);
    // Route::get('/get-barang', [PenjualanController::class, 'get_barang']);
    // Route::get('/get-nota-pesanan/{id}', [PenjualanController::class, 'get_nota_pesanan']);
    // Route::get('/penjualan/cari-barang', [PenjualanController::class, 'cari_barang']);
    // Route::post('/pesanan/tambah_pesanan', [PenggunaController::class, 'tambah_pesanan']);
    // Route::get('/penjualan/hapus-pesanan/{id}', [PenjualanController::class, 'hapus_pesanan']);
    // Route::post('/penjualan/ubah-jumlah-pesanan', [PenjualanController::class, 'ubah_jumlah_pesanan']);
    // Route::get('/checkout-nota/{id}', [PenjualanController::class, 'checkout_nota']);
    // Route::post('/penjualan/ubah-harga-satuan', [PenjualanController::class, 'ubah_harga_satuan']);
    // Route::get('/hapus_nota/{id}', [PenjualanController::class, 'hapus_nota']);

    

    

    // Analisi
    Route::get('/analisis-penjualan', [AnalisisController::class, 'analisis_penjualan']);
    Route::get('/analisis-montir', [AnalisisController::class, 'analisis_montir']);
    Route::get('/analisis-get-detail-nota/{id}', [AnalisisController::class, 'get_detail_nota']);
    Route::get('/analisis-export', [AnalisisController::class, 'export_analisis']);
    Route::get('/analisis-montir-export', [AnalisisController::class, 'export_analisis_montir']);

    // barcode
    Route::get('/barcode/{kode}', [BarcodeController::class, 'barcode']);

    // montir
    Route::get('/manajemen/montir/daftar-montir', [MontirController::class, 'daftar_montir']);
    Route::get('/manajemen/montir/hapus-montir/{id}', [MontirController::class, 'hapus_montir']);
    Route::post('/manajemen/montir/post-tambah-montir', [MontirController::class, 'post_tambah_montir']);

    Route::get('/riwayat-barang-masuk', [RiwayatController::class, 'riwayat_barang_masuk']);
    Route::get('/riwayat-barang-masuk-cari-nama-produk', [RiwayatController::class, 'riwayat_barang_masuk_cari_nama_produk']);
    Route::get('/riwayat-barang-masuk-cari-tgl-produk', [RiwayatController::class, 'riwayat_barang_masuk_cari_tgl_produk']);

    Route::get('/riwayat-barang-masuk/hapus-riwayat/{id}', [RiwayatController::class, 'hapus_riwayat_penerimaan_barang']);


});