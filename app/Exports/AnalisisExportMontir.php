<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Riwayat_nota;
use App\Models\Riwayat_pesanan;
use App\Models\Barang;

class AnalisisExportMontir implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $tanggal_awal;
    private $tanggal_akhir;

    public function setTanggal($tanggal_awal, $tanggal_akhir)
    {
        $this->tanggal_awal = $tanggal_awal;
        $this->tanggal_akhir = $tanggal_akhir;
    }

    public function view(): View
    {
        
        $riwayat_nota = Riwayat_nota::where([
            ['montir', '!=', ''],
            ['montir', '!=', '-'],
            ['montir',  '!=', null],
            ['tgl_nota', ">=" , $this->tanggal_awal],
            ['tgl_nota', '<=', $this->tanggal_akhir]
            
        ])->get()->groupBy('montir');
        
        $data_riwayat_nota = array();
        $i = 0;
       
        foreach ($riwayat_nota as $data => $transaksi) {
            $data_riwayat_nota[$i]['montir'] = $data;
            // $data_riwayat_nota[$i]['tanggal'] = $this->tanggal;
            $data_riwayat_nota[$i]['jumlah_transaksi'] = $transaksi->count();
            $total_jasa_transaksi = 0;
            $total_harga_transaksi = 0;
            
            $j = 0;
            foreach($transaksi as $row){

                $data_riwayat_nota[$i]['transaksi'][$j]['nama_pembeli'] = $row->nama_pembeli;
                $data_riwayat_nota[$i]['transaksi'][$j]['status'] = $row->status;
                $data_riwayat_nota[$i]['transaksi'][$j]['tanggal'] = $row->tgl_nota;

                $total_harga = 0;
                $total_jasa = 0;
                $riwayat_pesanan = Riwayat_pesanan::where('riwayat_nota_id', $row->id)->get();
                foreach($riwayat_pesanan as $pesanan){ 
                    $cek_barang = Barang::find($pesanan->barang_id);
                    if (isset($cek_barang)) {
                        if ($cek_barang->jenis == 'jasa') {
                            $total_jasa += $pesanan->jumlah * $pesanan->harga;
                        }
                    }
                    $total_harga += $pesanan->jumlah * $pesanan->harga;
                }

                $data_riwayat_nota[$i]['transaksi'][$j]['jasa'] = $total_jasa;
                $data_riwayat_nota[$i]['transaksi'][$j]['total_harga'] = $total_harga;

                $total_jasa_transaksi += $total_jasa;
                $total_harga_transaksi += $total_harga;

                $j++;
            }

            $data_riwayat_nota[$i]['total_jasa_transaksi'] = $total_jasa_transaksi;
            $data_riwayat_nota[$i]['total_harga_transaksi'] = $total_harga_transaksi;

            $i++;
        }
        
        return view('exports.analisis_montir', compact('data_riwayat_nota'));
    }
}
