<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Supplier;
use App\Models\Barang_masuk;

class BarangController extends Controller
{
    //
    public function daftar_barang(){
        $barang = Barang::all();
        return view('manajemen.barang.daftar_barang', compact('barang'));
    }

    public function post_tambah_barang(Request $request){
        
        $cek_barang = Barang::where('kode_barang', $request->kode_barang)->get();
        if(count($cek_barang) == 0){
            // Barang::create($request->all());
            $barang = new Barang;
            $barang->kode_barang = $request->kode_barang;
            $barang->nama_barang = $request->nama_barang;
            $barang->tipe_barang = $request->tipe_barang;
            $barang->satuan = $request->satuan;
            $barang->harga = $request->harga;
            $barang->laba = $request->laba;
            $barang->save();
            return back();
        }
        return back();
    }

    public function penerimaan_barang(){
        $barang_masuk = Barang_masuk::orderBy('tgl_masuk', 'asc')->take(10)->get();
        $supplier = Supplier::all();
        return view('manajemen.barang.barang_masuk', compact('barang_masuk', 'supplier'));
    }

    public function get_daftar_barang(Request $request){

        $keyword = $request->keyword;
        
        $barang = Barang::where('kode_barang', 'LIKE', '%'.$keyword.'%')->orWhere('nama_barang', 'LIKE', '%'.$keyword.'%')->get();
        $view = view('manajemen.barang.tabel_data_barang', compact('barang'))->render();
        return response()->json(['view'=>$view]);
    }

    public function post_barang_masuk(Request $request){
        $supplier = new Barang_masuk;
        $supplier->barang_id = $request->id_barang;
        $supplier->supplier_id = $request->id_supplier;
        $supplier->jumlah_barang = $request->jumlah;
        $supplier->save();

    }

    public function get_list_barang_masuk(){
        $barang_masuk = Barang_masuk::orderBy('tgl_masuk', 'asc')->take(10)->get();
        $view = view('manajemen.barang.data_list_barang_masuk', compact('barang_masuk'))->render();
        return response()->json(['view'=>$view]);
    }
}
