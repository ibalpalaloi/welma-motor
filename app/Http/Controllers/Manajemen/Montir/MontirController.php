<?php

namespace App\Http\Controllers\Manajemen\Montir;

use App\Http\Controllers\Controller;
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

        $notification = array(
            'title_message' => 'Berhasil',
            'message' => 'Montir Berhasil Terhapus', 
            'alert-type' => 'success'
         );   

        return redirect()->back()->with($notification);
    }

    public function post_tambah_montir(Request $request){
        $montir = new Montir;
        $montir->nama = $request->nama_montir;
        $montir->keterangan = $request->keterangan;
        $montir->save();

        $notification = array(
            'title_message' => 'Berhasil',
            'message' => 'Montir Berhasil Ditambahkan', 
            'alert-type' => 'success'
         );   

        return redirect()->back()->with($notification);
    }
}
