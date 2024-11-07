<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusTanah extends Model
{
    use HasFactory;
    public $table = 'tblstatus_tanah';
    public $primaryKey = 'statustanah_id';
    public $timestamps = false;
}
