<?php

namespace App\Http\Controllers\Manajemen\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    //
    public function data_supplier(){
        $supplier = Supplier::all();
        return view('manajemen.supplier.data_supplier', compact('supplier'));
    }

    public function post_ubah_supplier(Request $request){
        $validator = Validator::make($request->all(),[
            'id_supplier' => 'required',
            'nama' => 'required',
            'kontak' => 'required',
            'keterangan' => 'required'
        ]);

        if($validator->fails()){
            return redirect()->back();
        }

        $supplier = Supplier::find($request->id_supplier);
        $supplier->nama_supplier = $request->nama;
        $supplier->kontak = $request->kontak;
        $supplier->keterangan = $request->keterangan;
        $supplier->save();

        return back();
    }

    public function hapus_supplier($id){
        $supplier = Supplier::find($id);
        $supplier->delete();

        return back();
    }

    public function post_supplier_baru(Request $request){

        $validator = Validator::make($request->all(),[
            'nama_supplier' => 'required',
            'kontak_supplier' => 'required',
            'keterangan_supplier' => 'required'
        ]);

        if($validator->fails()){
            return redirect()->back();
        }

        $supplier = new Supplier;
        $supplier->nama_supplier = $request->nama_supplier;
        $supplier->kontak = $request->nama_supplier;
        $supplier->keterangan = $request->nama_supplier;
        $supplier->save();

        return back();
    }
}
