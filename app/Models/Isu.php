<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Isu extends Model
{
    use HasFactory;
    public $table = 'tblisue';
    public $primaryKey = 'isue_id';
    public $timestamps = false;

    function jenis(){
        return $this->belongsTo(JenisIsu::class, 'isue_type_id', 'isuetype_id');
    }

}
