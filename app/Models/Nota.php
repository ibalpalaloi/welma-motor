<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    use HasFactory;
    protected $table = "nota";

    public function pesanan(){
        return $this->hasMany(Pesanan::class);
    }
}
