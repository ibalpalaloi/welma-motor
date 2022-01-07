<?php

namespace App\Http\Controllers\Penjualan;

use App\Exports\AnalisisExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Riwayat_nota;
use App\Models\Riwayat_pesanan;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;

class AnalisisController extends Controller
{
    //
    public function analisis_penjualan(Request $request){
        date_default_timezone_set( 'Asia/Singapore' ) ;
        $date_today = date("Y-m-d");
        if(!empty($request->all())){
          
            if($request->status == "umum"){
                $nota = Riwayat_nota::where([
                    ['tgl_nota', $request->tgl], ['status', 'umum']
                ])->get();
            }elseif($request->status == "dinas"){
                $nota = Riwayat_nota::where([
                    ['tgl_nota', $request->tgl], ['status', 'dinas']
                ])->get();
            }else{
                $nota = Riwayat_nota::where('tgl_nota', $request->tgl)->get();
            }

            $tgl = $request->tgl;

            $status = $request->status;

        }
        else{
            $nota = Riwayat_nota::where('tgl_nota', $date_today)->get();
            $tgl = $date_today;
        }

        
        $data_nota = array();
        $i = 0;
        $total_harga = 0;
        $total_keuntungan = 0;
        foreach($nota as $data){
            $data_nota[$i]['id'] = $data->id;
            $data_nota[$i]['nama_pembeli'] = $data->nama_pembeli;
            $data_nota[$i]['tgl_nota'] = $data->tgl_nota;
            $data_nota[$i]['status'] = $data->status;
            $total_harga_pernota = 0;
            $total_keuntungan_pernota = 0;
            $total_modal = 0;
            foreach($data->riwayat_pesanan as $pesanan){
                $total_harga_pernota += $pesanan->harga;
                $total_keuntungan_pernota += $pesanan->harga - $pesanan->barang->harga_beli;
                $total_modal += $pesanan->barang->harga_beli;
            } 
            $data_nota[$i]['total_harga'] = $total_harga_pernota;
            $data_nota[$i]['total_keuntungan'] = $total_keuntungan_pernota;
            $data_nota[$i]['total_modal'] = $total_modal;
            $total_harga += $total_harga_pernota;
            $total_keuntungan += $total_keuntungan_pernota;
            $i++;
        }
        return view('manajemen.analisis.analisis_penjualan', compact('data_nota', 'total_harga', 'total_keuntungan', 'tgl','status'));
    }

    public function get_detail_nota($id){
        $riwayat_pesanan = Riwayat_pesanan::where('riwayat_nota_id', $id)->get();
        $riwayat_nota = Riwayat_nota::find($id);
        $data_pesanan = array();
        $i = 0;
        $total_harga = 0;
        $total_modal = 0;
        $total_keuntungan = 0;
        foreach($riwayat_pesanan as $pesanan){
            $data_pesanan[$i]['id'] = $pesanan->id;
            $data_pesanan[$i]['kode_barang'] = $pesanan->kode_barang;
            $data_pesanan[$i]['nama_barang'] = $pesanan->nama_barang;
            $data_pesanan[$i]['jumlah'] = $pesanan->jumlah;
            $data_pesanan[$i]['harga'] = $pesanan->harga;
            if($pesanan->barang){
                $data_pesanan[$i]['harga_beli'] = $pesanan->barang->harga_beli;
                $data_pesanan[$i]['merk'] = $pesanan->barang->merk;
                if (is_null($pesanan->barang->merk)) {
                    $data_pesanan[$i]['merk'] = '';

                }
                $data_pesanan[$i]['tipe'] = $pesanan->barang->tipe;
                if (is_null($pesanan->barang->tipe)) {
                    $data_pesanan[$i]['tipe'] = '';

                }
            }else{
                $data_pesanan[$i]['harga_beli'] = 0;
                $data_pesanan[$i]['merk'] = '';
                $data_pesanan[$i]['tipe'] = '';
            }
            $data_pesanan[$i]['keuntungan'] = $data_pesanan[$i]['harga'] - $data_pesanan[$i]['harga_beli'];
            $data_pesanan[$i]['total'] = $data_pesanan[$i]['jumlah'] * $data_pesanan[$i]['harga'];
            $total_harga += $data_pesanan[$i]['total'];
            $total_modal += $data_pesanan[$i]['harga_beli'];
            $total_keuntungan += $data_pesanan[$i]['keuntungan'];
            $i++;
        }
        return response()->json(['data_pesanan'=>$data_pesanan, 
                                'riwayat_nota'=>$riwayat_nota,
                                'total_harga'=>$total_harga, 
                                'total_modal'=>$total_modal, 
                                'total_keuntungan'=>$total_keuntungan]);
    }

    public function export_analisis(Request $request){
        $export = new AnalisisExport();
        $export->setTanggal($request->tgl);
        return Excel::download($export, $request->tgl.'.xlsx');
    }
}
