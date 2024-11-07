<?php

namespace App\Models\Premis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyewaan extends Model
{
    use HasFactory;
    public $table = 'pre_tblsewa';
    public $primaryKey = 'penyewaan_id';
    public $timestamps = false;

    function fasiliti(){
        return $this->belongsTo(\App\Models\Fasiliti::class, 'peny_fasilti_id', 'fasiliti_id');
    }

    function syarikat(){
        return $this->belongsTo(\App\Models\Premis\Syarikat::class, 'peny_syarikat_id', 'syarikat_id');
    }

    function pengguna(){
        return $this->belongsTo(\App\Models\Pengguna::class, 'user_id', 'syarikat_id');
    }
}
