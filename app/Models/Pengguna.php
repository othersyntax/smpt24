<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    use HasFactory;
    public $table = 'tbluser';
    public $primaryKey = 'user_id';
    public $timestamps = false;

    function namaPTJ(){
        return $this->belongsTo(\App\Models\PusatTanggungjawab::class, 'user_jkn', 'ptj_id');
    }
}
