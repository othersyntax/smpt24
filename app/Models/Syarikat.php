<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Syarikat extends Model
{
    use HasFactory;
    public $table = 'pre_tblsyarikat';
    public $primaryKey = 'syarikat_id';
    public $timestamps = false;
}
