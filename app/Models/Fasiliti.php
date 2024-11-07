<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fasiliti extends Model
{
    use HasFactory;
    public $table = 'tblfasiliti';
    public $primaryKey = 'fasiliti_id';
    public $timestamps = false;

    function tanah(){
        return $this->belongsTo(\App\Models\Tanah::class, 'fas_tanah_id', 'tanah_id');
    }
}
