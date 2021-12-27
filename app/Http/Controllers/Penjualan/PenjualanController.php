<?php

namespace App\Http\Controllers\Penjualan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Nota;
use App\Models\Stok;
use App\Models\Barang;
use App\Models\Riwayat_nota;
use App\Models\Riwayat_pesanan;

class PenjualanController extends Controller
{
    //
    public function penjualan_barang(Request $request){
        $list_nota = Nota::all(); 
        // dd($request->all());
        if(count($request->all())>0){
            $list_nota = Nota::where('id', '!=', $request->id_nota)->get();
            $nota = Nota::find($request->id_nota);
            $this->cek_nota($request->id_nota);
            $total_pesanan = 0;
            foreach($nota->pesanan as $pesanan){
                $total_pesanan += $pesanan->jumlah * $pesanan->harga;
            }
            return view('manajemen.penjualan.penjualan', compact('list_nota', 'nota', 'total_pesanan'));
        }
        
        return view('manajemen.penjualan.penjualan', compact('list_nota'));
    }

    public function cek_nota($id){
        $pesanan = Pesanan::where('nota_id', $id)->get();
        foreach($pesanan as $data){
            if($data->barang == null){
                Pesanan::where('id', $data->id)->delete();
            }
        }
    }

    public function post_tambah_nota(Request $request){
        $nota = new Nota;
        $nota->nama_pembeli = $request->nama;
        $nota->status = $request->status;
        $nota->user_id = Auth()->user()->id;
        $nota->save();

        $notification = array(
            'title_message' => 'Berhasil',
            'message' => 'Nota Berhasil Ditambahkan', 
            'alert-type' => 'success'
         );   


        return redirect('/penjualan?id_nota='.$nota->id)->with($notification);
    }

    public function get_barang(Request $request){
        $id_nota = $request->id_nota;
        $kode_barang = $request->kode_barang;
        $barang = Barang::where('kode_barang', $kode_barang)->first();
        if(!empty($barang)){
            if($barang->stok != null){
                if($barang->stok->stok > 0){
                    $stok = Stok::where('barang_id', $barang->id)->first();
                    $stok->stok = $stok->stok - 1;
                    $stok->save();
                    $status = "sukses";
                    $tambah_pesanan = $this->tambah_pesanan($barang->id, $id_nota);
                    $id_pesanan = $tambah_pesanan->id;
                    $total_pesanan = $this->get_total_pesanan($id_nota);
                    $nota = Nota::find($id_nota);
                    $html = view('manajemen.penjualan.data_list_penjualan', compact('nota'))->render();
                    return response()->json(['html'=>$html, 'status'=>$status, 'total_pesanan'=>$total_pesanan]);
                    // return response()->json(['barang'=>$barang, 'status'=>$status, 'total_pesanan'=>$total_pesanan, 'id_pesanan'=>$id_pesanan]);
                }
                else{
                    $status = "stok habis";
                    return response()->json(['status'=>$status]);
                }
            }
            else{
                $status = "stok habis";
                return response()->json(['status'=>$status]);
            }
        }else{
            $status = "gagal";
            return response()->json(['status'=>$status]);
        }
    }

    public function tambah_pesanan($id_barang, $id_nota){
        $barang = Barang::find($id_barang);
        $pesanan = Pesanan::where([
                        ['barang_id', $id_barang],
                        ['nota_id', $id_nota]
        ])->first();
        if(!empty($pesanan)){
            $pesanan->jumlah = $pesanan->jumlah + 1;
            $pesanan->save();
        }else{
            $pesanan = new Pesanan;
            $pesanan->nota_id = $id_nota;
            $pesanan->barang_id = $id_barang;
            $pesanan->harga = $barang->harga;
            $pesanan->jumlah = 1;
            $pesanan->save();
        }
        return $pesanan;
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
        $jumlah_lama = $pesanan->jumlah;
        $jumlah_baru = $request->jumlah;
        $selisih = $jumlah_lama - $jumlah_baru;
        $stok = Stok::where('barang_id', $pesanan->barang_id)->first();
        $jumlah_stok = $stok->stok + $selisih;
        if($jumlah_stok < 0){
            return response()->json([
                'status'=>'stok tidak tesedia',
                'jumlah'=>$jumlah_lama,
            ]);
        }
        else{
            $pesanan->jumlah = $request->jumlah;
            $pesanan->save();
            $stok->stok = $jumlah_stok;
            $stok->save();
            return response()->json([
                'status'=>'sukses',
                'jumlah'=>$request->jumlah,
            ]);
        }
    }

    public function checkout_nota($id){
        $nota = Nota::find($id);
        $riwayat_nota = new Riwayat_nota;
        $riwayat_nota->nama_pembeli = $nota->nama_pembeli;
        $riwayat_nota->user_id = Auth()->user()->id;
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

        return redirect("/nota/".$riwayat_nota->id);
    }

    public function ubah_harga_satuan(Request $request){
        $pesanan = Pesanan::find($request->id);
        $pesanan->harga = $request->harga_satuan;
        $pesanan->save();

        return response()->json(['pesanan'=>$pesanan]);
    }

    public function hapus_nota($id){
        Nota::where('id', $id)->delete();
        Pesanan::where('nota_id', $id)->delete();

        $notification = array(
            'title_message' => 'Berhasil',
            'message' => 'Nota Berhasil Terhapus', 
            'alert-type' => 'success'
         );   
        return redirect('/penjualan')->with($notification);
    }

    
}
