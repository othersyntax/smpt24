<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    use HasFactory;
    public $table = 'tbldokumen';
    public $primaryKey = 'dokumen_id';
    public $timestamps = false;
}
