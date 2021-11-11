<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Riwayat_pesanan extends Model
{
    use HasFactory;
    protected $table = "riwayat_pesanan";

    public function riwayat_nota(){
        return $this->belongsTo(Riwayat_nota::class);
    }

    public function barang(){
        return $this->belongsTo(Barang::class);
    }
}
