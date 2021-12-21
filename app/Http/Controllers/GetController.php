<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nota;
use App\Models\Pesanan;
use App\Models\Barang;
use App\Models\Supplier;

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

    public function get_barang($id){
        $barang = Barang::find($id);

        return response()->json(['barang'=>$barang]);
    }

    public function get_pesanan($id){
        $pesanan = Pesanan::find($id);

        return response()->json(['pesanan'=>$pesanan]);
    }

    public function get_supplier($id){
        $supplier = Supplier::find($id);

        return response()->json(['supplier'=>$supplier]);
    }
}
