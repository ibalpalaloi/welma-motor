<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Riwayat_nota;
use App\Models\Riwayat_pesanan;

class AnalisisExportMontir implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $tanggal;
    public function setTanggal($tanggal)
    {
        $this->tanggal = $tanggal;
    }

    public function view(): View
    {
        
        $riwayat_nota = Riwayat_nota::where([
            ['montir', '!=', ''],
            ['montir', '!=', '-'],
            ['montir',  '!=', null],
            ['tgl_nota',$this->tanggal]
        ])->get();
        
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
        
        return view('exports.analisis_montir', compact('data_riwayat_nota'));
    }
}
