<?php

namespace App\Models\Premis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Syarikat extends Model
{
    use HasFactory;
    public $table = 'pre_tblsyarikat';
    public $primaryKey = 'syarikat_id';
    public $timestamps = false;

    function negeri(){
        return $this->belongsTo(\App\Models\Negeri::class, 'sya_negeri_id', 'neg_kod_negeri');
    }
}
