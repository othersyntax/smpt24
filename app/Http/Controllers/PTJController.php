<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PusatTanggungjawab;
use Illuminate\Support\Facades\DB;

class PTJController extends Controller
{
    function index(Request $req){
        $queryType = 1; // default click pd menu    
        if($req->isMethod('post')) {
            $kod_negeri  = $req->kod_negeri;
            $kod_daerah = $req->kod_daerah;
            $kod_mukim  = $req->kod_mukim;
            $ptj_code = $req->ptj_code;
            $ptj_nama = $req->ptj_nama;
            session([
                'kod_negeri' => $kod_negeri,
                'kod_daerah' => $kod_daerah,
                'kod_mukim' => $kod_mukim,
                'ptj_code' => $ptj_code,
                'ptj_nama' => $ptj_nama
            ]);
            $queryType = 2;
        }
        else{
            if($req->has('page')) {         
                $kod_negeri = session('kod_negeri');
                $kod_daerah = session('kod_daerah');       
                $kod_mukim = session('kod_mukim');
                $ptj_code = session('ptj_code');
                $ptj_nama = session('ptj_nama');
                $queryType = 2;
            }
            else{
                session()->forget(['ptj_code', 'ptj_nama', 'kod_mukim', 'kod_daerah', 'kod_negeri']);
            }
            
        }

        if ($queryType == 1) {
            $ptj = DB::table('tblptj')
                        ->leftJoin('ddsa_kod_bandar', 'tblptj.ptj_kod_bandar','=', 'ddsa_kod_bandar.ban_kod_bandar')
                        ->leftJoin('ddsa_kod_daerah', 'ddsa_kod_bandar.ban_kod_daerah','=', 'ddsa_kod_daerah.dae_kod_daerah')
                        ->leftJoin('ddsa_kod_negeri', 'ddsa_kod_daerah.dae_kod_negeri','=', 'ddsa_kod_negeri.neg_kod_negeri')
                        ->select('tblptj.*', 'ddsa_kod_bandar.ban_nama_bandar')
                        ->paginate(20);
            $data['ptj'] = $ptj;
        } 
        else {
            $query = DB::table('tblptj')
                        ->leftJoin('ddsa_kod_bandar', 'tblptj.ptj_kod_bandar','=', 'ddsa_kod_bandar.ban_kod_bandar')
                        ->leftJoin('ddsa_kod_daerah', 'ddsa_kod_bandar.ban_kod_daerah','=', 'ddsa_kod_daerah.dae_kod_daerah')
                        ->leftJoin('ddsa_kod_negeri', 'ddsa_kod_daerah.dae_kod_negeri','=', 'ddsa_kod_negeri.neg_kod_negeri')
                        ->select('tblptj.*', 'ddsa_kod_bandar.ban_nama_bandar')
                        ->where(function($q) use ($ptj_code, $ptj_nama, $kod_negeri, $kod_daerah, $kod_mukim){
                            if(!empty($kod_negeri)){
                                $q->where('ddsa_kod_negeri.neg_kod_negeri',$kod_negeri);
                            }
                            if(!empty($kod_daerah)){
                                $q->where('ddsa_kod_daerah.dae_kod_daerah',$kod_daerah);
                            }
                            if(!empty($kod_mukim)){
                                $q->where('ddsa_kod_bandar.ban_kod_bandar',$kod_mukim);
                            }
                            if(!empty($ptj_code)){
                                $q->where('tblptj.ptj_code',$ptj_code);
                            }                
                            if(!empty($ptj_nama)){
                                $q->where('tblptj.ptj_nama','like', "%{$ptj_nama}%");
                            }                            
                        });
            
            $ptj = $query->paginate(20);
            $data['ptj'] = $ptj;
        }       

        return view('utiliti/ptj.index', $data);
    }

    function simpan(Request $req){
        $ptj_id = $req->ptj_id;

        if(empty($ptj_id)){
            $ptj = new PusatTanggungjawab();
            $ptj->ptj_created_by = session('loginID');
            $ptj->ptj_updated_by = session('loginID');
        }
        else{
            $ptj = PusatTanggungjawab::find($ptj_id);            
            $ptj->ptj_updated_by = session('loginID');
        }

        $ptj->ptj_code = $req->ptj_code;
        $ptj->ptj_nama = $req->ptj_nama;
        // $ptj->ptj_kod_negeri = $req->kod_negeri1;
        // $ptj->ptj_kod_daerah = $req->kod_daerah1;
        $ptj->ptj_kod_bandar = $req->ptj_kod_bandar;
        $ptj->ptj_status = $req->ptj_status;
        // dd($ptj);
        $simpan = $ptj->save();
        if($simpan){
            $output='';
            $ptj = DB::table('tblptj')
                    ->leftJoin('ddsa_kod_bandar', 'tblptj.ptj_kod_bandar','=', 'ddsa_kod_bandar.ban_kod_bandar')
                    ->leftJoin('ddsa_kod_daerah', 'ddsa_kod_bandar.ban_kod_daerah','=', 'ddsa_kod_daerah.dae_kod_daerah')
                    ->leftJoin('ddsa_kod_negeri', 'ddsa_kod_daerah.dae_kod_negeri','=', 'ddsa_kod_negeri.neg_kod_negeri')
                    ->select('tblptj.*', 'ddsa_kod_bandar.ban_nama_bandar')
                    ->paginate(20);
            $output .= '  
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <th class="text-center" width="5%">No.</th>
                        <th width="10%">Kod PTJ / PK</th>
                        <th width="40%">Nama PTJ / PK</th>
                        <th width="25%">Mukim / Bandar</th>
                        <th width="10%">Status</th>
                        <th class="text-center" width="10%">Tindakan</th>
                    </thead>
                    <tbody>
                ';  
            $padammsj = 'Anda pasti untuk padam';
            $no = $ptj->firstItem();
            foreach($ptj as $p){
                $output .= '                                                     
                    <tr>
                        <td class="text-center">'.$no++.'</td>
                        <td>'.$p->ptj_code.'</td>
                        <td>'.$p->ptj_nama.'</td>
                        <td>'.$p->ban_nama_bandar.'</td>
                        <td>'.statusAktif($p->ptj_status).'</td>                               
                        <td class="text-center">
                            <a href="#" id="'.$p->ptj_id.'" class="btn btn-xs btn-info edit_ptj" title="Kemaskini">
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
        $ptj = DB::table('tblptj')
                    ->leftJoin('ddsa_kod_bandar', 'tblptj.ptj_kod_bandar','=', 'ddsa_kod_bandar.ban_kod_bandar')
                    ->leftJoin('ddsa_kod_daerah', 'ddsa_kod_bandar.ban_kod_daerah','=', 'ddsa_kod_daerah.dae_kod_daerah')
                    ->leftJoin('ddsa_kod_negeri', 'ddsa_kod_daerah.dae_kod_negeri','=', 'ddsa_kod_negeri.neg_kod_negeri')
                    ->select('tblptj.*', 'ddsa_kod_daerah.dae_kod_daerah', 'ddsa_kod_negeri.neg_kod_negeri')
                    ->where('tblptj.ptj_id',$req->ptj_id)
                    ->first();
// dd($ptj);
        echo json_encode($ptj);
    }
}
