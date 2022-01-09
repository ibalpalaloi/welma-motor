<?php

namespace App\Exports;

use App\Models\Riwayat_nota;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AnalisisExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $tanggal;
    private $nota;

    public function setStatusNota($nota){

        $this->nota = $nota;
    }

    public function setTanggal($tanggal)
    {
        $this->tanggal = $tanggal;
    }

    
    public function view(): View
    {
        //

        $cek_status_nota = $this->nota;

        if ($cek_status_nota == 'semua') {
            $riwayat_nota = Riwayat_nota::where('tgl_nota', $this->tanggal)->get();

        } else {
            $riwayat_nota = Riwayat_nota::where('tgl_nota', $this->tanggal)->where('status', $this->nota)->get();

        }
        
        
        
        return view('exports.analisis', compact('riwayat_nota'));
    }
}
