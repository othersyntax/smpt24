<?php

namespace App\Models\Premis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bayaran extends Model
{
    use HasFactory;
    public $table = 'pre_tblbayaran';
    public $primaryKey = 'bayaran_id';
    public $timestamps = false;
}
