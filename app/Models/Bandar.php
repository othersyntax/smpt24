<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bandar extends Model
{
    use HasFactory;
    public $table = 'ddsa_kod_bandar';
    public $primaryKey = 'ban_bandar_id';
    public $timestamps = false;

    function daerah1(){
        return $this->belongsTo(\App\Models\Daerah::class, 'ban_kod_bandar', 'dae_kod_daerah');
    }

}
