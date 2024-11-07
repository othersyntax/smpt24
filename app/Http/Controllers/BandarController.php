<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Bandar;

class BandarController extends Controller
{
    function index(Request $req){
        $queryType = 1; // default click pd menu    
        if($req->isMethod('post')) {
            $neg_kod_negeri = $req->neg_kod_negeri;
            $dae_kod_daerah = $req->dae_kod_daerah;
            $namamukim  = $req->namamukim;
            session([
                'neg_kod_negeri' => $neg_kod_negeri,
                'dae_kod_daerah' => $dae_kod_daerah,
                'namamukim' => $namamukim
            ]);
            $queryType = 2;
        }
        else{
            if($req->has('page')) {
                $neg_kod_negeri = session('neg_kod_negeri');
                $dae_kod_daerah = session('dae_kod_daerah');
                $namamukim = session('namamukim');
                $queryType = 2;
            }
            else{
                session()->forget(['neg_kod_negeri', 'dae_kod_daerah', 'namamukim']);
            }
            
        }

        if ($queryType == 1) {
            $mukim = DB::table('ddsa_kod_bandar')
                        ->join('ddsa_kod_daerah', 'ddsa_kod_bandar.ban_kod_daerah','=', 'ddsa_kod_daerah.dae_kod_daerah')
                        ->join('ddsa_kod_negeri', 'ddsa_kod_daerah.dae_kod_negeri','=', 'ddsa_kod_negeri.neg_kod_negeri')
                        ->select('ddsa_kod_bandar.*', 'ddsa_kod_daerah.dae_nama_daerah')
                        ->paginate(20);
            $data['mukim'] = $mukim;
        } 
        else {
            $query = DB::table('ddsa_kod_bandar')
                        ->join('ddsa_kod_daerah', 'ddsa_kod_bandar.ban_kod_daerah','=', 'ddsa_kod_daerah.dae_kod_daerah')
                        ->join('ddsa_kod_negeri', 'ddsa_kod_daerah.dae_kod_negeri','=', 'ddsa_kod_negeri.neg_kod_negeri')
                        ->select('ddsa_kod_bandar.*', 'ddsa_kod_daerah.dae_nama_daerah')
                        ->where(function($q) use ($neg_kod_negeri, $dae_kod_daerah, $namamukim){
                if(!empty($neg_kod_negeri)){
                    $q->where('ddsa_kod_negeri.neg_kod_negeri',$neg_kod_negeri);
                }
    
                if(!empty($dae_kod_daerah)){
                    $q->where('ddsa_kod_daerah.dae_kod_daerah',$dae_kod_daerah);
                }

                if(!empty($namamukim)){
                    $q->where('ddsa_kod_bandar.ban_nama_bandar','like', "%{$namamukim}%");
                }
            });
            
            $mukim = $query->paginate(20);
            $data['mukim'] = $mukim;
        }
        // dd($data);       

        return view('utiliti/bandar.index', $data);
    }

    function simpan(Request $req){
        $ban_bandar_id = $req->ban_bandar_id;

        if(empty($ban_bandar_id)){
            $mukim = new Bandar();
            $mukim->ban_crtby = session('loginID');
            $mukim->ban_updby = session('loginID');
            $mukim->ban_log = date('Y-m-d H:i:s');
        }
        else{
            $mukim = Bandar::find($ban_bandar_id);
            $mukim->ban_updby = session('loginID');
        }

        $mukim->ban_kod_bandar = $req->ban_kod_bandar;
        $mukim->ban_nama_bandar = $req->ban_nama_bandar;
        $mukim->ban_kod_daerah = $req->ban_kod_daerah;
        $mukim->ban_kod_negeri = $req->ban_kod_negeri;

        // dd($mukim);
        $simpan = $mukim->save();
        if($simpan){
            $output='';
            $mukim = DB::table('ddsa_kod_bandar')
                        ->join('ddsa_kod_daerah', 'ddsa_kod_bandar.ban_kod_daerah','=', 'ddsa_kod_daerah.dae_kod_daerah')
                        ->join('ddsa_kod_negeri', 'ddsa_kod_daerah.dae_kod_negeri','=', 'ddsa_kod_negeri.neg_kod_negeri')
                        ->select('ddsa_kod_bandar.*', 'ddsa_kod_daerah.dae_nama_daerah')
                        ->paginate(20);
            $output .= '  
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <th class="text-center" width="5%">No.</th>
                        <th width="10%">Kod</th>
                        <th width="40%">Bandar</th>
                        <th width="30%">Daerah</th>
                        <th class="text-center" width="15%">Tindakan</th>
                    </thead>
                    <tbody>
                ';  
            $padammsj = 'Anda pasti untuk padam';
            $no = $mukim->firstItem();
            foreach($mukim as $mkm){
                $mkm->ban_kod_bandar;
                $output .= '                                                     
                    <tr>
                        <td class="text-center">'.$no++.'</td>
                        <td>'.$mkm->ban_kod_bandar.'</td>
                        <td>'.$mkm->ban_nama_bandar.'</td>
                        <td>'.$mkm->dae_nama_daerah.'</td>                                
                        <td class="text-center">
                            <a href="#" id="'.$mkm->ban_bandar_id.'" class="btn btn-xs btn-info edit_mukim" title="Kemaskini">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="#"
                                onclick=" return confirm('.$padammsj.')" title="Hapus Aktiviti">
                                <i class="fas fa-trash text-danger"></i>
                            </a>
                        </td>
                    </tr>
                ';  
            }

            $output .= '</tbody>
                        </table>'; 
           
        }
        else{
            $output='Gagal';
        }
        echo $output; 
    }

    function ubah(Request $req){
        $mukim = Bandar::find($req->ban_bandar_id);
        echo json_encode($mukim);
    }
}
