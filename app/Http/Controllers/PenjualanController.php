<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Nota;
use App\Models\Barang;
use App\Models\Riwayat_nota;
use App\Models\Riwayat_pesanan;

class PenjualanController extends Controller
{
    //
    public function penjualan_barang(Request $request){
        $list_nota = Nota::all(); 
        if(count($request->all())>0){
            $nota = Nota::find($request->id_nota);
            $total_pesanan = 0;
            foreach($nota->pesanan as $pesanan){
                $total_pesanan += $pesanan->jumlah * $pesanan->harga;
            }
            return view('manajemen.penjualan.penjualan', compact('list_nota', 'nota', 'total_pesanan'));
        }
        
        return view('manajemen.penjualan.penjualan', compact('list_nota'));
    }

    public function post_tambah_nota(Request $request){
        $nota = new Nota;
        $nota->nama_pembeli = $request->nama;
        $nota->status = $request->status;
        $nota->save();

        return redirect('/penjualan-barang?id_nota='.$nota->id);
    }

    public function get_barang(Request $request){
        $id_nota = $request->id_nota;
        $kode_barang = $request->kode_barang;
        $barang = Barang::where('kode_barang', $kode_barang)->first();
        if(!empty($barang)){
            $status = "sukses";
            $this->tambah_pesanan($barang->id, $id_nota);
            $total_pesanan = $this->get_total_pesanan($id_nota);
            return response()->json(['barang'=>$barang, 'status'=>$status, 'total_pesanan'=>$total_pesanan]);
        }else{
            $status = "gagal";
            return response()->json(['status'=>$status]);
        }
    }

    public function tambah_pesanan($id_barang, $id_nota){
        $barang = Barang::find($id_barang);
        $pesanan = new Pesanan;
        $pesanan->nota_id = $id_nota;
        $pesanan->barang_id = $id_barang;
        $pesanan->harga = $barang->harga;
        $pesanan->jumlah = 1;
        $pesanan->save();
    }

    public function get_total_pesanan($id_nota){
        $nota = Nota::find($id_nota);
        $total_pesanan = 0;
        foreach($nota->pesanan as $pesanan){
            $total_pesanan += $pesanan->jumlah * $pesanan->harga;
        }

        return $total_pesanan;
    }

    public function cari_barang(Request $request){
        $keyword = $request->keyword;
        $barang = Barang::where('kode_barang', 'LIKE', '%'.$keyword.'%')->orWhere('nama_barang', 'LIKE', '%'.$keyword.'%')->get();
        $view = view('manajemen.penjualan.tabel_data_cari_barang', compact('barang'))->render();
        return response()->json(['view'=>$view]);
    }

    public function hapus_pesanan($id){
        Pesanan::where('id', $id)->delete();
    }

    public function ubah_jumlah_pesanan(Request $request){
        $pesanan = Pesanan::find($request->id_pesanan);
        $pesanan->jumlah = $request->jumlah;
        $pesanan->save();

        return response()->json([
            'status'=>'sukses',
            'jumlah'=>$request->jumlah,
        ]);
    }

    public function checkout_nota($id){
        $nota = Nota::find($id);
        $riwayat_nota = new Riwayat_nota;
        $riwayat_nota->nama_pembeli = $nota->nama_pembeli;
        $riwayat_nota->tgl_nota = $nota->tgl_nota;
        $riwayat_nota->status =$nota->status;
        $riwayat_nota->save();
        foreach($nota->pesanan as $pesanan){
            $barang = Barang::find($pesanan->barang_id);
            $riwayat_pesanan = new Riwayat_pesanan;
            $riwayat_pesanan->riwayat_nota_id = $riwayat_nota->id;
            $riwayat_pesanan->barang_id = $barang->id;
            $riwayat_pesanan->kode_barang = $barang->kode_barang;
            $riwayat_pesanan->nama_barang = $barang->nama_barang;
            $riwayat_pesanan->jumlah = $pesanan->jumlah;
            $riwayat_pesanan->harga =$pesanan->harga;
            $riwayat_pesanan->save();
        }
        Pesanan::where('nota_id', $nota->id)->delete();
        $nota->delete();

        return redirect('/penjualan-barang');
    }
}
