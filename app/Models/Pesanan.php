<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;
    protected $table = "pesanan";
     public function nota(){
         return $this->belongsTo(Nota::class);
     }

     public function barang(){
         return $this->belongsTo(Barang::class);
     }
}
