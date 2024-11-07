<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\RuangSewa;

class RuangSewaController extends Controller
{
    function index(Request $req){
        return view('utiliti/ruang-sewa.index');
    }

    function simpan(Request $req){
        
    }


    function ubah(Request $req){
      
    }
}
