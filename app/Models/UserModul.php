<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModul extends Model
{
    use HasFactory;
    public $table = 'tbluser_module';
    public $primaryKey = 'user_module_id';
    public $timestamps = false;
}
