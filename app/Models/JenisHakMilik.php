<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisHakMilik extends Model
{
    use HasFactory;
    public $table = 'tbljenis_hak_milik';
    public $primaryKey = 'jenishm_id';
    public $timestamps = false;
}
