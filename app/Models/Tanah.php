<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tanah extends Model
{
    use HasFactory;    
    public $table = 'tbltanah';
    public $primaryKey = 'tanah_id';
    public $timestamps = false;

    function jenisHakMilik(){
        return $this->belongsTo(\App\Models\JenisHakMilik::class, 'tanah_jenis_hakmilik', 'jenishm_id');
    }

    function negeri(){
        return $this->belongsTo(\App\Models\Negeri::class, 'tanah_kod_negeri', 'neg_kod_negeri');
    }

    function daerah(){
        return $this->belongsTo(\App\Models\Daerah::class, 'tanah_kod_daerah', 'dae_kod_daerah');
    }

    function bandar(){
        return $this->belongsTo(\App\Models\Bandar::class, 'tanah_kod_bandar', 'ban_kod_bandar');
    }

    function statusTanahDB(){
        return $this->belongsTo(\App\Models\StatusTanah::class, 'tanah_status_tanah', 'statustanah_id');
    }
}

