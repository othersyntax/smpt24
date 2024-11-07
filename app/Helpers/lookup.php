<?php
use App\Models\Negeri;
use App\Models\Daerah;
use App\Models\Reference;

function aliasDaerah($kod){
    $daerah = Daerah::where('dae_kod_daerah', $kod)->get();
    foreach($daerah as $b){
        $data = $b->dae_nama_daerah;
    }
    return $data;
}

// function LtiStatusTanah($kod){
//     if($kod==0)
//         return "Baru";
//     else if($kod==1)
//         return "Sah Milik";
//     else
//     return "Tidak Sah Milik";
// }