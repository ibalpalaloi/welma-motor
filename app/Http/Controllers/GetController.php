<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nota;
use App\Models\Pesanan;

class GetController extends Controller
{
    //

    public function get_total_harga_nota($id){
        $nota = Nota::find($id);
        $total_pesanan = 0;
        foreach($nota->pesanan as $pesanan){
            $total_pesanan += $pesanan->jumlah * $pesanan->harga;
        }

        return response()->json(['total_pesanan'=>$total_pesanan]);
    }
}
