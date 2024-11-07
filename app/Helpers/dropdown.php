<?php
use App\Models\Negeri;
use App\Models\Daerah;
use App\Models\Bandar;
use App\Models\JenisHakMilik;
use App\Models\Pengguna;
use App\Models\StatusTanah;
use App\Models\PusatTanggungjawab;
use App\Models\Premis\Syarikat;


function pusatTjwb(){
    $ptj = PusatTanggungjawab::where('ptj_status', '1')
        ->orderBy('ptj_nama')
        ->pluck('ptj_nama', 'ptj_id')
        ->prepend('--Sila Pilih--', '');
    return $ptj;
}

function negeri(){
    $negeri = Negeri::where('neg_status', '1')
        ->orderBy('neg_nama_negeri')
        ->pluck('neg_nama_negeri', 'neg_kod_negeri')
        ->prepend('--Sila Pilih--', '');
    return $negeri;
}

function daerah(){
    $daerah = Daerah::where('dae_status', '1')
        ->orderBy('dae_nama_daerah')
        ->pluck('dae_nama_daerah', 'dae_kod_daerah')
        ->prepend('--Sila Pilih--', '');
    return $daerah;
}

function bandar(){
    $bandar = Bandar::where('ban_status', '1')
        ->orderBy('ban_nama_bandar')
        ->pluck('ban_nama_bandar', 'ban_kod_bandar')
        ->prepend('--Sila Pilih--', '');
    return $bandar;
}

function jenisHakMilik(){
    $subptp = JenisHakMilik::where('jenishm_status', '1')
        ->orderBy('jenishm_sort')
        ->pluck('jenishm_desc', 'jenishm_id')
        ->prepend('--Sila Pilih--', '');
    return $subptp;
}

function namaSyarikat(){
    $syarikat = Syarikat::orderBy('sya_desc')
        ->pluck('sya_desc', 'syarikat_id')
        ->prepend('--Sila Pilih--', '');
    return $syarikat;
}


function statusTanah(){
    $statt = StatusTanah::where('statt_status', '1')
        ->orderBy('statt_desc')
        ->pluck('statt_desc', 'statustanah_id')
        ->prepend('--Sila Pilih--', '');
    return $statt;
}

function aliasPeranan($kod){
    if($kod==1)
        return 'Pentadbir';
    else if($kod==2)
        return 'Pusat Tanggungjawab';
    else
        return 'Pusat Kos';
}

function aliasModul($kod){
    if($kod==1)
        return 'Tanah';
    else if($kod==2)
        return 'Premis';
    else
        return 'Utiliti';
}

function statusAktif($kod){
    if($kod==1)
        return 'Aktif';
    else
        return 'Tidak Aktif';
}

function aliasPengguna($kod){
    $user = Pengguna::find($kod);
    // dd($user);
    return $user->user_name;
}