<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Riwayat_nota;
use App\Models\Riwayat_pesanan;

class RiwayatController extends Controller
{
    //
    public function riwayat_nota(){
        $nota = Riwayat_nota::all();
        $data_riwayat_nota = array();
        $i = 0;
        foreach($nota as $data){
            $data_riwayat_nota[$i]['id'] = $data->id;
            $data_riwayat_nota[$i]['nama_pembeli'] = $data->nama_pembeli;
            $data_riwayat_nota[$i]['nama_admin'] = $data->user->nama;
            $data_riwayat_nota[$i]['tgl_nota'] = $data->tgl_nota;
            $total_harga = 0;
            foreach($data->riwayat_pesanan as $riwayat_pesanan){
                $total_harga = $riwayat_pesanan->jumlah * $riwayat_pesanan->harga;
            }
            $data_riwayat_nota[$i]['total_harga'] = $total_harga;
        }
        return view('manajemen.riwayat.riwayat_nota', compact('data_riwayat_nota'));
    }
}
