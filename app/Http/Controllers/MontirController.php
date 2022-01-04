<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Montir;

class MontirController extends Controller
{
    //
    public function daftar_montir(){
        $montir = Montir::all();
        return view('manajemen.montir.daftar_montir', compact('montir'));
    }

    public function hapus_montir($id){
        Montir::find($id)->delete();
        return back();
    }

    public function post_tambah_montir(Request $request){
        $montir = new Montir;
        $montir->nama = $request->nama_montir;
        $montir->keterangan = $request->keterangan;
        $montir->save();

        return back();
    }
}
