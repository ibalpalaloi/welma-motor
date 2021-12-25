<?php

namespace App\Http\Controllers\Manajemen\Barang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BarcodeController extends Controller
{
    //
    public function barcode($kode){
        return view('manajemen.barcode.barcode', compact('kode'));
    }
}
