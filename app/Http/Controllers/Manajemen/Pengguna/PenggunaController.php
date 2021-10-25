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
}
