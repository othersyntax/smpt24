<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisIsu extends Model
{
    use HasFactory;
    public $table = 'tblisuetype';
    public $primaryKey = 'isuetype_id';
    public $timestamps = false;
}
