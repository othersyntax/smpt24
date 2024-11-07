<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Utiliti extends Model
{
    use HasFactory;
    public $table = 'tblutiliti';
    public $primaryKey = 'utiliti_id';
    public $timestamps = false;
}
