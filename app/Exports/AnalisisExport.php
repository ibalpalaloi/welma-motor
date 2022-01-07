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

    public function setTanggal($tanggal)
    {
        $this->tanggal = $tanggal;
    }

    
    public function view(): View
    {
        //
        $riwayat_nota = Riwayat_nota::where('tgl_nota', $this->tanggal)->get();
        
        return view('exports.analisis', compact('riwayat_nota'));
    }
}
