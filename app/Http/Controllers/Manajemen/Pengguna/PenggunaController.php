<?php

namespace App\Http\Controllers\Manajemen\Pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class PenggunaController extends Controller
{
    //

    public function index(){

        $daftar = User::all();

        return view('manajemen.pengguna.index', compact('daftar'));
    }

    public function post_pengguna_baru(Request $request){
        $user = new User;
        $user->username = $request->username;
        $user->nama = $request->nama;
        $user->roles = $request->role;
        $user->password = bcrypt($request->password);
        $user->save();

        return back();
    }

    public function hapus_pengguna($id){
        $user = User::find($id);
        $user->delete();
        return back();
    }
}
