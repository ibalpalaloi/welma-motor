<?php

namespace App\Http\Controllers\Manajemen\Pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\User;

class PenggunaController extends Controller
{
    //

    public function index(){

        $daftar = User::where('roles','!=','superadmin')->get();

        return view('manajemen.pengguna.index', compact('daftar'));
    }

    public function post_tambah_pengguna(Request $request){

        // dd($request->all());

        $validator = Validator::make($request->all(), [
            'username_pengguna' => 'required|unique:posts',
            'nama_pengguna' => 'required',
            'level_akses_pengguna' => 'required',
            'password_pengguna' => 'required'
        ]);

        $user = new User;
        $user->username = $request->username_pengguna;
        $user->nama = $request->nama_pengguna;
        $user->roles = $request->level_akses_pengguna;
        $user->email = 'tes@gmail.com';
        $user->password =  \Hash::make($request->password_pengguna);
        $user->save();

        $notification = array(
            'title_message' => 'Berhasil',
            'message' => 'Pengguna Berhasil Ditambahkan', 
            'alert-type' => 'success'
         );   

        
        return redirect()->back()->with($notification);
    }

    public function post_ubah_pengguna(Request $request){

        // dd($request->all());

        $validator = Validator::make($request->all(), [
            'users_id' => 'required',
            'username_pengguna_ubah' => 'required|unique:posts',
            'nama_pengguna_ubah' => 'required',
            'level_akses_pengguna_ubah' => 'required'
        ]);

        $user = User::find($request->users_id);
        $user->username = $request->username_pengguna_ubah;
        $user->nama = $request->nama_pengguna_ubah;
        $user->roles = $request->level_akses_pengguna_ubah;
        if ($request->get('password_pengguna_ubah')) {
            $user->password =  \Hash::make($request->password_pengguna_ubah);

        }
        $user->save();
        
        $notification = array(
            'title_message' => 'Berhasil',
            'message' => 'Pengguna Berhasil Diubah', 
            'alert-type' => 'success'
         );   

        return redirect()->back()->with($notification);
    }

    public function hapus_pengguna($id){

        $user = User::find($id);
        $user->delete();
        
        return back();
    }
}
