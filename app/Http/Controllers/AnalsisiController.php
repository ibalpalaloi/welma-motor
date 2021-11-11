<?php

namespace App\Http\Controllers;

use App\Models\Riwayat_nota;
use App\Models\Riwayat_pesanan;
use Illuminate\Http\Request;

class AnalsisiController extends Controller
{
    //
    public function analisis_penjualan(){
        date_default_timezone_set( 'Asia/Singapore' ) ;
        $date_today = date("Y-m-d");
        $nota = Riwayat_nota::where('tgl_nota', $date_today)->get();
        $data_nota = array();
        $i = 0;
        $total_harga = 0;
        $total_keuntungan = 0;
        foreach($nota as $data){
            $data_nota[$i]['id'] = $data->id;
            $data_nota[$i]['nama_pembeli'] = $data->nama_pembeli;
            $data_nota[$i]['tgl_nota'] = $data->tgl_nota;
            $total_harga_pernota = 0;
            $total_keuntungan_pernota = 0;
            foreach($data->riwayat_pesanan as $pesanan){
                $total_harga_pernota += $pesanan->harga;
                $total_keuntungan_pernota += $pesanan->harga - $pesanan->barang->harga;
            } 
            $data_nota[$i]['total_harga'] = $total_harga_pernota;
            $data_nota[$i]['total_keuntungan'] = $total_keuntungan_pernota;
            $total_harga += $total_keuntungan_pernota;
            $total_keuntungan += $total_keuntungan_pernota;
            $i++;
        }
        return view('analisis.analisis_penjualan', compact('data_nota'));
    }
}
