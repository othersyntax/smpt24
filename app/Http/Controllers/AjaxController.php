<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Daerah;
use App\Models\Bandar;
use App\Models\Tanah;
use App\Models\Fasiliti;
use Form;

class AjaxController extends Controller
{
   function ajaxDaerah(Request $req) {
        $neg_kod_negeri = $req->neg_kod_negeri;
        $inputname = $req->inputname;
        $rs = Daerah::where('dae_kod_negeri', $neg_kod_negeri)
            ->orderBy('dae_nama_daerah')
            ->pluck('dae_nama_daerah', 'dae_kod_daerah')
            ->prepend('--Sila Pilih--', '');
        echo Form::select($inputname, $rs, session($inputname),
        ['class' => 'form-control', 'id' => $inputname,'name' => $inputname]);
    }

    function ajaxMukim(Request $req) {
        $inputname = $req->inputname;
        $dae_kod_daerah = $req->dae_kod_daerah;
        $rs = Bandar::where('ban_kod_daerah', $dae_kod_daerah)
            ->orderBy('ban_nama_bandar')
            ->pluck('ban_nama_bandar', 'ban_kod_bandar')
            ->prepend('--Sila Pilih--', '');
        echo Form::select($inputname, $rs, session($inputname),
        ['class' => 'form-control', 'id' => $inputname,'name' => $inputname]);
        // dd($rs);
    }

    function ajaxFasiliti(Request $req) {
        $inputname = $req->inputname;
        $rs = Tanah::where('tanah_kod_bandar', $req->ban_kod_bandar)
            ->orderBy('tanah_desc')
            ->pluck('tanah_desc', 'tanah_id')
            ->prepend('--Sila Pilih--', '');
        echo Form::select($inputname, $rs, session($inputname),
        ['class' => 'form-control', 'id' => $inputname,'name' => $inputname]);
        // dd($rs);
    }

    function ajaxRuang(Request $req) {
        $inputname = $req->inputname;
        $rs = Fasiliti::where('fas_tanah_id', $req->tanah_id)
            ->orderBy('fas_desc')
            ->pluck('fas_desc', 'fasiliti_id')
            ->prepend('--Sila Pilih--', '');
        echo Form::select($inputname, $rs, session($inputname),
        ['class' => 'form-control', 'id' => $inputname,'name' => $inputname]);
        // dd($rs);
    }
}
