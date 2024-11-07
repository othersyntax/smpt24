<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Negeri extends Model
{
    use HasFactory;    
    public $table = 'ddsa_kod_negeri';
    public $primaryKey = 'neg_negeri_id';
    public $timestamps = false;

    function daerah(){
        return $this->belongsTo(\App\Models\Daerah::class, 'neg_kod_negeri', 'dae_kod_negeri');
    }
}
