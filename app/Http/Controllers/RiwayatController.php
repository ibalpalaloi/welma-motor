<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Riwayat_nota;
use App\Models\Riwayat_pesanan;
use App\Models\Nota;
use App\Models\Pesanan;
use App\Models\Barang_masuk;

class RiwayatController extends Controller
{
    //
    public function riwayat_nota(){
        $nota = Riwayat_nota::orderBy('tgl_nota', 'desc')->paginate(50);
        $data_riwayat_nota = array();
        $i = 0;
        foreach($nota as $data){
            $data_riwayat_nota[$i]['id'] = $data->id;
            $data_riwayat_nota[$i]['nama_pembeli'] = $data->nama_pembeli;
            if($data->user){
                $data_riwayat_nota[$i]['nama_admin'] = $data->user->nama;
            }else{
                $data_riwayat_nota[$i]['nama_admin'] = '-';
            }
            
            $data_riwayat_nota[$i]['tgl_nota'] = $data->tgl_nota;
            $total_harga = 0;
            foreach($data->riwayat_pesanan as $riwayat_pesanan){
                $total_harga += $riwayat_pesanan->jumlah * $riwayat_pesanan->harga;
            }
            $data_riwayat_nota[$i]['total_harga'] = $total_harga;
            $i++;
        }
        return view('manajemen.riwayat.riwayat_nota', compact('data_riwayat_nota'));
    }

    public function nota($id){
        $riwayat_nota = Riwayat_nota::find($id);
        return view('manajemen.nota', compact('riwayat_nota'));
    }

    public function batal_checkout($id){
        $riwayat_nota = Riwayat_nota::find($id);
        if($riwayat_nota == null){
            return back();
        }

        $nota = new Nota;
        $nota->nama_pembeli = $riwayat_nota->nama_pembeli;
        $nota->tgl_nota = $riwayat_nota->tgl_nota;
        $nota->status = $riwayat_nota->status;
        $nota->user_id = $riwayat_nota->user_id;
        $nota->save();

        foreach($riwayat_nota->riwayat_pesanan as $data){
            $pesanan = new Pesanan;
            $pesanan->nota_id = $nota->id;
            $pesanan->barang_id = $data->barang_id;
            $pesanan->harga = $data->harga;
            $pesanan->jumlah = $data->jumlah;
            $pesanan->save();
        }

        $riwayat_nota->delete();
        Riwayat_pesanan::where('riwayat_nota_id', $id)->delete();

        return back();
    }
    
    public function riwayat_barang_masuk(Request $request){
        $barang_masuk = Barang_masuk::orderBy('tgl_masuk', 'desc')->paginate(50);
        $daftar_barang = array();
        $i=0;
        foreach($barang_masuk as $data){
            $daftar_barang[$i]['nama'] = $data->barang->nama_barang;
            $daftar_barang[$i]['tipe'] = $data->barang->tipe_barang;
        }
        return view('manajemen.riwayat.riwayat_barang_masuk', compact('barang_masuk'));
    }

    public function riwayat_barang_masuk_cari_nama_produk(Request $request){
        $keyword = $request->keyword;
        $barang_masuk = Barang_masuk::whereHas('barang', function($query) use($keyword){
            $query->where('nama_barang', 'LIKE', '%'.$keyword.'%');
        })->get();
        $view = view('manajemen.riwayat.data_riwayat_barang_masuk', compact('barang_masuk'))->render();
        return response()->json(['html'=>$view]);
    }

    public function riwayat_barang_masuk_cari_tgl_produk(Request $request){
        $keyword = $request->keyword;
        $barang_masuk = Barang_masuk::where('tgl_masuk', $keyword)->get();
        $view = view('manajemen.riwayat.data_riwayat_barang_masuk', compact('barang_masuk'))->render();
        return response()->json(['html'=>$view]);
    }

    public function load_riwayat_nota(Request $request){
        $nota = Riwayat_nota::orderBy('tgl_nota', 'desc')->paginate(50);
        $data_riwayat_nota = array();
        $i = 0;
        foreach($nota as $data){
            $data_riwayat_nota[$i]['id'] = $data->id;
            $data_riwayat_nota[$i]['nama_pembeli'] = $data->nama_pembeli;
            if($data->user){
                $data_riwayat_nota[$i]['nama_admin'] = $data->user->nama;
            }else{
                $data_riwayat_nota[$i]['nama_admin'] = '-';
            }
            
            $data_riwayat_nota[$i]['tgl_nota'] = $data->tgl_nota;
            $total_harga = 0;
            foreach($data->riwayat_pesanan as $riwayat_pesanan){
                $total_harga += $riwayat_pesanan->jumlah * $riwayat_pesanan->harga;
            }
            $data_riwayat_nota[$i]['total_harga'] = $total_harga;
            $i++;
        }
        $view = view('/manajemen.riwayat.data_riwayat_nota', compact('data_riwayat_nota'))->render();

        return response()->json(['view'=>$view]);
    }
}
