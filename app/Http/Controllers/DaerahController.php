<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Daerah;

class DaerahController extends Controller
{
    function index(Request $req){
        $queryType = 1; // default click pd menu    
        if($req->isMethod('post')) {
            $dae_kod_negeri = $req->dae_kod_negeri1;
            $dae_nama_daerah = $req->dae_nama_daerah;
            session([
                'dae_kod_negeri' => $dae_kod_negeri,
                'dae_nama_daerah' => $dae_nama_daerah,
            ]);
            $queryType = 2;
        }
        else{
            if($req->has('page')) {
                $dae_kod_negeri = session('dae_kod_negeri');
                $dae_nama_daerah = session('dae_nama_daerah');
                $queryType = 2;
            }
            else{
                session()->forget(['dae_kod_negeri', 'dae_nama_daerah']);
            }
            
        }

        if ($queryType == 1) {
            $daerah = \DB::table('ddsa_kod_daerah')
                        ->leftJoin('ddsa_kod_negeri', 'ddsa_kod_daerah.dae_kod_negeri','=', 'ddsa_kod_negeri.neg_kod_negeri')
                        ->select('ddsa_kod_daerah.*', 'ddsa_kod_negeri.neg_nama_negeri')
                        ->orderBy('dae_nama_daerah','ASC')
                        ->paginate(10);
            $data['daerah'] = $daerah;
        } 
        else {
            $query = \DB::table('ddsa_kod_daerah')
                        ->leftJoin('ddsa_kod_negeri', 'ddsa_kod_daerah.dae_kod_negeri','=', 'ddsa_kod_negeri.neg_kod_negeri')
                        ->select('ddsa_kod_daerah.*', 'ddsa_kod_negeri.neg_nama_negeri')
                        ->orderBy('dae_nama_daerah')
                        ->where(function($q) use ($dae_nama_daerah, $dae_kod_negeri){
                if(!empty($dae_nama_daerah)){
                    $q->where('dae_nama_daerah',$dae_nama_daerah);
                }    
                if(!empty($dae_kod_negeri)){
                    $q->where('dae_kod_negeri',$dae_kod_negeri);
                }
            });
            
            $daerah = $query->paginate(10);
            $data['daerah'] = $daerah;
        }       

        return view('utiliti/daerah.index', $data);
    }

    function simpan(Request $req){
        $dae_daerah_id = $req->dae_daerah_id;

        if(empty($dae_daerah_id)){
            $daerah = new Daerah();
            $daerah->dae_crtby = session('loginID');
            $daerah->dae_updby = session('loginID');
            $daerah->dae_log = date('Y-m-d H:i:s');
        }
        else{
            $daerah = Daerah::find($dae_daerah_id);
            $daerah->dae_updby = session('loginID');
        }

        $daerah->dae_kod_daerah = $req->dae_kod_daerah;
        $daerah->dae_nama_daerah = $req->dae_nama_daerah;
        $daerah->dae_kod_negeri = $req->dae_kod_negeri;
        $daerah->dae_status = $req->dae_status;

        // dd($daerah);
        $simpan = $daerah->save();
        if($simpan){
            $output='';
            $daerah = \DB::table('ddsa_kod_daerah')
                    ->leftJoin('ddsa_kod_negeri', 'ddsa_kod_daerah.dae_kod_negeri','=', 'ddsa_kod_negeri.neg_kod_negeri')
                    ->select('ddsa_kod_daerah.*', 'ddsa_kod_negeri.neg_nama_negeri')
                    ->orderBy('dae_nama_daerah','ASC')
                    ->paginate(10);
            $output .= '  
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <th class="text-center" width="5%">No.</th>
                        <th class="text-center" width="10%">Kod</th>
                        <th width="30%">Daerah</th>
                        <th width="25%">Negeri</th>
                        <th width="15%">Status</th>
                        <th class="text-center" width="15%">#</th>
                    </thead>
                    <tbody>
                ';
            $no = $daerah->firstItem();
            foreach($daerah as $dae){
                $output .= '
                    <tr>
                        <td class="text-center">'.$no++.'</td>
                        <td class="text-center">'.$dae->dae_kod_daerah.'</td>
                        <td>'.$dae->dae_nama_daerah.'</td>
                        <td>'.$dae->neg_nama_negeri.'</td> 
                        <td>'.statusAktif($dae->dae_status).'</td>                               
                        <td class="text-center">
                            <a href="#" id="'.$dae->dae_daerah_id.'" class="btn btn-xs btn-info edit_daerah" title="Kemaskini">
                                <i class="fas fa-edit"></i>
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
        $daerah = Daerah::find($req->dae_daerah_id);
        echo json_encode($daerah);
    }
}
