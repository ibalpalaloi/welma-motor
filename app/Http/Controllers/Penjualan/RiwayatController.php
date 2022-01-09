<?php

namespace App\Http\Controllers\Penjualan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Riwayat_nota;
use App\Models\Riwayat_pesanan;
use App\Models\Stok;
use App\Models\Nota;
use App\Models\Pesanan;
use App\Models\Barang_masuk;
use PDF;

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
            $data_riwayat_nota[$i]['status'] = ucwords($data->status);
            
            if ($data->montir) {
                $data_riwayat_nota[$i]['montir'] = $data->montir;
            }
            else{
                $data_riwayat_nota[$i]['montir'] = '-';
            }
      

            $total_harga = 0;
            foreach($data->riwayat_pesanan as $riwayat_pesanan){
                $total_harga += $riwayat_pesanan->jumlah * $riwayat_pesanan->harga;
            }
            $data_riwayat_nota[$i]['total_harga'] = $total_harga;
            $i++;
        }
        return view('manajemen.riwayat.riwayat_nota', compact('data_riwayat_nota'));
    }

    public function nota($jenis, $id){
        $riwayat_nota = Riwayat_nota::find($id);

        $pdf = PDF::loadView('manajemen.nota_2', ['riwayat_nota'=>$riwayat_nota]);

        $width_paper = 8.5*72;
        $height_paper = 5.5*72;
        $custom_size_paper = array(0, 0, $width_paper, $height_paper );

        if ($jenis == 'lihat') {

            return $pdf->setPaper($custom_size_paper, 'potrait')->stream('Nota_'.$riwayat_nota->nama_pembeli.'_'.$riwayat_nota->tgl_nota.'.pdf', array("Attachment" => 0));
        }
    
        if ($jenis == 'download') {

            return $pdf->setPaper($custom_size_paper, 'potrait')->download('Nota_'.$riwayat_nota->nama_pembeli.'_'.$riwayat_nota->tgl_nota.'.pdf');
        }

        // $pdf = PDF::loadview('manajemen.nota', ['riwayat_nota'=>$riwayat_nota]);
        // return $pdf->stream();

        // return view('manajemen.nota_2', compact('riwayat_nota'));
    }

    public function download_nota($id){
        $riwayat_nota = Riwayat_nota::find($id);
        $pdf = PDF::loadview('manajemen.nota_2', ['riwayat_nota'=>$riwayat_nota]);
        return $pdf->download($riwayat_nota->nama_pembeli.".pdf");
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
        $nota->montir = $riwayat_nota->montir;
        $nota->save();

        foreach($riwayat_nota->riwayat_pesanan as $data){
            $pesanan = new Pesanan;
            $pesanan->nota_id = $nota->id;            
            $pesanan->barang_id = $data->barang_id;
            $pesanan->nama_barang = $data->nama_barang;
            $pesanan->harga = $data->harga;
            $pesanan->jumlah = $data->jumlah;
            $pesanan->save();
        }

        $riwayat_nota->delete();
        Riwayat_pesanan::where('riwayat_nota_id', $id)->delete();

        return back();
    }
    
    public function riwayat_barang_masuk(Request $request){
        $barang_masuk = Barang_masuk::orderBy('tgl_masuk', 'desc')->paginate(40);
        $daftar_barang = array();
        $i=0;
        foreach($barang_masuk as $data){
            $daftar_barang[$i]['id'] = $data->id;
            if($data->barang){
                $daftar_barang[$i]['nama_barang'] = $data->barang->nama_barang;
                $daftar_barang[$i]['tipe'] = $data->barang->tipe_barang;
                $daftar_barang[$i]['merk'] = $data->barang->merk;
                $daftar_barang[$i]['kode_barang'] = $data->barang->kode_barang;
            }
            else{
                $daftar_barang[$i]['nama_barang'] = "";
                $daftar_barang[$i]['tipe'] = "";
                $daftar_barang[$i]['merk'] = "";
                $daftar_barang[$i]['kode_barang'] = "";
            }
            
            $daftar_barang[$i]['jumlah'] = $data->jumlah_barang;

            if($data->supplier){
                $daftar_barang[$i]['supplier'] = $data->supplier->nama_supplier;
            }else{
                $daftar_barang[$i]['supplier'] = "";
            }
            $date = date_create($data->tgl_masuk);
            $daftar_barang[$i]['tgl_masuk'] = date_format($date, 'd-M-Y');
            $i++;
        }
        if(count($request->all()) > 0){
            $html = view('manajemen.riwayat.data_riwayat_barang_masuk', compact('daftar_barang'))->render();
            return response()->json(['html'=>$html]);
        }
        return view('manajemen.riwayat.riwayat_barang_masuk', compact('barang_masuk', 'daftar_barang'));
    }

    public function riwayat_barang_masuk_cari_nama_produk(Request $request){
        $keyword = $request->keyword;
        $barang_masuk = Barang_masuk::whereHas('barang', function($query) use($keyword){
            $query->where('nama_barang', 'LIKE', '%'.$keyword.'%');
        })->get();
        $daftar_barang = array();
        $i=0;
        foreach($barang_masuk as $data){
            $daftar_barang[$i]['id'] = $data->id;
            if($data->barang){
                $daftar_barang[$i]['nama_barang'] = $data->barang->nama_barang;
                $daftar_barang[$i]['tipe'] = $data->barang->tipe_barang;
                $daftar_barang[$i]['merk'] = $data->barang->merk;
                $daftar_barang[$i]['kode_barang'] = $data->barang->kode_barang;
            }
            else{
                $daftar_barang[$i]['nama_barang'] = "";
                $daftar_barang[$i]['tipe'] = "";
                $daftar_barang[$i]['merk'] = "";
                $daftar_barang[$i]['kode_barang'] = "";
            }
            
            $daftar_barang[$i]['jumlah'] = $data->jumlah_barang;

            if($data->supplier){
                $daftar_barang[$i]['supplier'] = $data->supplier->nama_supplier;
            }else{
                $daftar_barang[$i]['supplier'] = "";
            }
            $date = date_create($data->tgl_masuk);
            $daftar_barang[$i]['tgl_masuk'] = date_format($date, 'd-M-Y');
            $i++;
        }
        $view = view('manajemen.riwayat.data_riwayat_barang_masuk', compact('daftar_barang'))->render();
        return response()->json(['html'=>$view]);
    }

    public function riwayat_barang_masuk_cari_tgl_produk(Request $request){
        $keyword = $request->keyword;
        $barang_masuk = Barang_masuk::where('tgl_masuk', $keyword)->get();
        $daftar_barang = array();
        $i=0;
        foreach($barang_masuk as $data){
            $daftar_barang[$i]['id'] = $data->id;
            if($data->barang){
                $daftar_barang[$i]['nama_barang'] = $data->barang->nama_barang;
                $daftar_barang[$i]['tipe'] = $data->barang->tipe_barang;
                $daftar_barang[$i]['merk'] = $data->barang->merk;
                $daftar_barang[$i]['kode_barang'] = $data->barang->kode_barang;
            }
            else{
                $daftar_barang[$i]['nama_barang'] = "";
                $daftar_barang[$i]['tipe'] = "";
                $daftar_barang[$i]['merk'] = "";
                $daftar_barang[$i]['kode_barang'] = "";
            }
            
            $daftar_barang[$i]['jumlah'] = $data->jumlah_barang;

            if($data->supplier){
                $daftar_barang[$i]['supplier'] = $data->supplier->nama_supplier;
            }else{
                $daftar_barang[$i]['supplier'] = "";
            }
            $date = date_create($data->tgl_masuk);
            $daftar_barang[$i]['tgl_masuk'] = date_format($date, 'd-M-Y');
            $i++;
        }
        $view = view('manajemen.riwayat.data_riwayat_barang_masuk', compact('daftar_barang'))->render();
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
            $data_riwayat_nota[$i]['status'] = ucwords($data->status);
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

    public function riwayat_nota_tgl(Request $request){
        if($request->status == "umum"){
            $nota = Riwayat_nota::where([
                ['tgl_nota', $request->tgl], ['status', 'umum']
            ])->get();
        }elseif($request->status == "dinas"){
            $nota = Riwayat_nota::where([
                ['tgl_nota', $request->tgl], ['status', 'dinas']
            ])->get();
        }else{
            $nota = Riwayat_nota::where('tgl_nota', $request->tgl)->get();
        }
        
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
                
            if ($data->montir) {
                $data_riwayat_nota[$i]['montir'] = $data->montir;
            }
            else{
                $data_riwayat_nota[$i]['montir'] = '-';
            }
            $data_riwayat_nota[$i]['status'] = ucwords($data->status);
            $data_riwayat_nota[$i]['tgl_nota'] = $data->tgl_nota;
            $total_harga = 0;
            foreach($data->riwayat_pesanan as $riwayat_pesanan){
                $total_harga += $riwayat_pesanan->jumlah * $riwayat_pesanan->harga;
            }
            $data_riwayat_nota[$i]['total_harga'] = $total_harga;
            $i++;
        }
        $view = view('manajemen.riwayat.data_riwayat_nota', compact('data_riwayat_nota'))->render();

        return response()->json(['view'=>$view]);
    }

    public function hapus_riwayat_penerimaan_barang($id){

        $barang_masuk = Barang_masuk::find($id);

        $stok = Stok::where('barang_id', $barang_masuk->barang_id)->first();
        if(isset($stok)){
            $stok->stok = $stok->stok + $barang_masuk->jumlah_barang;
            $stok->save();
        }
        $barang_masuk->delete();

        $notification = array(
            'title_message' => 'Berhasil',
            'message' => 'Riwayat Barang Masuk Berhasil Terhapus', 
            'alert-type' => 'success'
         );   

        return redirect()->back()->with($notification);
    }
}
