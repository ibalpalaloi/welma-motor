<?php

namespace App\Http\Controllers\Penjualan;

use App\Exports\AnalisisExport;
use App\Exports\AnalisisExportMontir;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Riwayat_nota;
use App\Models\Riwayat_pesanan;
use App\Models\User;
use App\Models\Barang;
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
                    ['tgl_nota', ">=" , $request->tgl_mulai], ['tgl_nota', '<=', $request->tgl_akhir], ['status', 'umum']
                ])->get();
            }elseif($request->status == "dinas"){
                $nota = Riwayat_nota::where([
                    ['tgl_nota', ">=" , $request->tgl_mulai], ['tgl_nota', '<=', $request->tgl_akhir], ['status', 'dinas']
                ])->get();
            }else{
                $nota = Riwayat_nota::where([
                    ['tgl_nota', ">=" , $request->tgl_mulai], ['tgl_nota', '<=', $request->tgl_akhir]
                ])->get();
            }

            $tgl_mulai = $request->tgl_mulai;
            $tgl_akhir = $request->tgl_akhir;

            $status = $request->status;

        }
        else{
            $nota = Riwayat_nota::where('tgl_nota', $date_today)->get();
            $tgl_mulai = $date_today;
            $tgl_akhir = $date_today;
            $status = 'semua';

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
                if($pesanan->barang){
                    $total_keuntungan_pernota += $pesanan->harga - $pesanan->barang->harga_beli;
                    $total_modal += $pesanan->barang->harga_beli;
                }
                else{
                    $total_keuntungan_pernota += $pesanan->harga - 0;
                    $total_modal += 0;
                }
                
            } 
            $data_nota[$i]['total_harga'] = $total_harga_pernota;
            $data_nota[$i]['total_keuntungan'] = $total_keuntungan_pernota;
            $data_nota[$i]['total_modal'] = $total_modal;
            $total_harga += $total_harga_pernota;
            $total_keuntungan += $total_keuntungan_pernota;
            $i++;
        }
        return view('manajemen.analisis.analisis_penjualan', compact('data_nota', 'total_harga', 'total_keuntungan', 'tgl_mulai', 'tgl_akhir','status'));
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

        $export->setTanggal($request->tgl_mulai, $request->tgl_akhir);
        $export->setStatusNota($request->status);
        return Excel::download($export, "Penjualan-(".$request->tgl_mulai.")"." - "."(".$request->tgl_akhir.")".'.xlsx');

        // if ($request->status == 'semua') {
        //     $riwayat_nota = Riwayat_nota::where('tgl_nota', $request->tgl)->get();

        // } else {
        //     $riwayat_nota = Riwayat_nota::where('tgl_nota', $request->tgl)->where('status', $request->status)->get();

        // }
        
        
        
        // return view('exports.analisis', compact('riwayat_nota'));
    }

    public function export_analisis_montir(Request $request){
        $export = new AnalisisExportMontir();
        $export->setTanggal($request->tgl_awal, $request->tgl_akhir);
        return Excel::download($export, "Montir-(".$request->tgl_awal.")"." - "."(".$request->tgl_akhir.")".'.xlsx');
        
    }

    public function analisis_montir(Request $request){
        date_default_timezone_set( 'Asia/Singapore' ) ;

        $date_today = date("Y-m-d");

        if(count($request->all()) > 0){
            
            // dd($request->all());
            $riwayat_nota = Riwayat_nota::where([
                ['montir', '!=', ''],
                ['montir', '!=', '-'],
                ['montir',  '!=', null],
                ['tgl_nota', ">=" , $request->tgl_awal], ['tgl_nota', '<=', $request->tgl_akhir]
            ])->get();

            $tgl_awal = $request->tgl_awal;
            $tgl_akhir = $request->tgl_akhir;

            
        }else{
      
            $riwayat_nota = Riwayat_nota::where([
                ['montir', '!=', ''],
                ['montir', '!=', '-'],
                ['montir',  '!=', null],
                ['tgl_nota', $date_today]
            ])->get();

            $tgl_awal = $date_today;
            $tgl_akhir = $date_today;

        }

        // dd($riwayat_nota);
        
        $data_riwayat_nota = array();
        $i = 0;
        
        foreach($riwayat_nota as $data){
            $data_riwayat_nota[$i]['id'] = $data->id;
            $data_riwayat_nota[$i]['pembeli'] = $data->nama_pembeli;
            $data_riwayat_nota[$i]['montir'] = $data->montir;
            $data_riwayat_nota[$i]['tgl_nota'] = $data->tgl_nota;
            $riwayat_pesanan = Riwayat_pesanan::where('riwayat_nota_id', $data->id)->get();
            $jumlah_transaksi = 0;
            foreach($riwayat_pesanan as $pesanan){
                $jumlah_transaksi += $pesanan->jumlah * $pesanan->harga;
            }
            $data_riwayat_nota[$i]['jumlah_transaksi'] = $jumlah_transaksi;
            $i++;
        }

        
        return view('manajemen.analisis.analisis_montir', compact('data_riwayat_nota', 'tgl_awal','tgl_akhir'));
    }
}
