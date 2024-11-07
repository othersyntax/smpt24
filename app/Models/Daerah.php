<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Daerah extends Model
{
    use HasFactory;    
    public $table = 'ddsa_kod_daerah';
    public $primaryKey = 'dae_daerah_id';
    public $timestamps = false;

    function bandar(){
        return $this->belongsTo(\App\Models\Bandar::class, 'dae_kod_daerah', 'ban_kod_daerah');
    }
}
