<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;
    public $table = 'tblpenilaian_tanah';
    public $primaryKey = 'penilaian_id';
    public $timestamps = false;
}
