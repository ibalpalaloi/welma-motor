<?php

namespace App\Http\Controllers\Manajemen\Barang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Supplier;
use App\Models\Barang_masuk;
use App\Models\Stok;


class BarangController extends Controller
{
    //
    public function daftar_barang(){
        $barang = Barang::OrderBy('nama_barang','asc')->get();
        return view('manajemen.barang.daftar_barang', compact('barang'));
    }

    public function post_tambah_barang(Request $request){

        // dd($request->all());
        
        $cek_barang = Barang::where('kode_barang', $request->kode_barang)->get();
        // dd($cek_barang);
        if(count($cek_barang) == 0){
            // Barang::create($request->all());
            $barang = new Barang;
            $barang->kode_barang = $request->kode_barang;
            $barang->nama_barang = $request->nama_barang;
            $barang->merk = $request->merk;
            $barang->tipe_barang = $request->tipe_barang;
            $barang->satuan = $request->keterangan_satuan;
            $barang->harga = $request->harga_jual;
            $barang->harga_beli = $request->harga_modal;
            $barang->save();

            $notification = array(
                'title_message' => 'Berhasil',
                'message' => 'Barang Berhasil Ditambahkan', 
                'alert-type' => 'success'
             );   

            return back()->with($notification);
        }

        $notification = array(
            'title_message' => 'Pemberitahuan',
            'message' => 'Barang Telah Dimasukkan', 
            'alert-type' => 'Info'
         );   
         
        return back()->with($notification);
    }

    public function penerimaan_barang(){
        $barang_masuk = Barang_masuk::orderBy('tgl_masuk', 'desc')->take(10)->get();
        $supplier = Supplier::all();
        // dd($barang_masuk[0]->barang->nama_barang);
        return view('manajemen.barang.barang_masuk', compact('barang_masuk', 'supplier'));
    }

    public function get_daftar_barang(Request $request){
        $keyword = $request->keyword;
        if ($keyword != null) {
            $barang = Barang::where('kode_barang', 'LIKE', '%'.$keyword.'%')->orWhere('nama_barang', 'LIKE', '%'.$keyword.'%')->get();
        }
        else{

            $barang = Barang::take(0)->get();
        }

        $view = view('manajemen.barang.tabel_data_barang', compact('barang'))->render();
        return response()->json(['view'=>$view]);
    }

    public function post_barang_masuk(Request $request){
        $supplier = new Barang_masuk;
        $supplier->barang_id = $request->id_barang;
        $supplier->supplier_id = $request->id_supplier;
        $supplier->jumlah_barang = $request->jumlah;
        
        $stok_barang = Stok::where('barang_id',$request->id_barang)->first();
        $stok = $stok_barang->stok;
        $stok_barang->stok = $stok + $request->jumlah;
        $stok_barang->save();
        
        $supplier->save();

    }

    public function get_list_barang_masuk(){
        $barang_masuk = Barang_masuk::orderBy('tgl_masuk', 'desc')->take(20)->get();
        $view = view('manajemen.barang.data_list_barang_masuk', compact('barang_masuk'))->render();
        return response()->json(['view'=>$view]);
    }

    public function hapus_barang($id){
        Barang::where('id', $id)->delete();

        return back();
    }

    public function ubah_stok(Request $request, $id){
        $cek_stok = Stok::where('barang_id', $id)->first();
        if($cek_stok != null){
            $cek_stok->stok = $request->stok;
            $cek_stok->save();
        }else{
            $cek_stok = new Stok;
            $cek_stok->barang_id = $request->id_barang;
            $cek_stok->stok = $request->stok;
            $cek_stok->save();
        }

        return response()->json(['stok'=>$cek_stok]);
    }

    public function post_ubah_barang(Request $request){
        $barang = Barang::find($request->id_barang);
        $barang->kode_barang = $request->kode_barang;
        $barang->nama_barang = $request->nama_barang;
        $barang->merk = $request->merk;
        $barang->tipe_barang = $request->tipe_barang;
        $barang->satuan = $request->keterangan_satuan;
        $barang->harga = $request->harga_jual;
        $barang->harga_beli = $request->harga_modal;
        $barang->save();

        $notification = array(
            'title_message' => 'Berhasil',
            'message' => 'Barang Berhasil Diubah', 
            'alert-type' => 'success'
         );   
        
        return back()->with($notification);
    }
}
