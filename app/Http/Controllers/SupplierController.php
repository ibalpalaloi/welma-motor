<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    //
    public function data_supplier(){
        $supplier = Supplier::all();
        return view('manajemen.supplier.data_supplier', compact('supplier'));
    }
}
