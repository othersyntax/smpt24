<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\Negeri;

class NegeriController extends Controller
{
    function index(Request $req){
        $queryType = 1; // default click pd menu    
        if($req->isMethod('post')) {
            $carian_type = $req->carian_type;
            $carian_text = $req->carian_text;
            session([
                'carian_type' => $carian_type,
                'carian_text' => $carian_text
            ]);
            $queryType = 2;
        }
        else{
            if($req->has('page')) {
                $carian_type = session('carian_type');
                $carian_text = session('carian_text');
                $queryType = 2;
            }
            else{
                session()->forget(['carian_type', 'carian_text']);
            }
            
        }

        if ($queryType == 1) {
            $negeri = Negeri::orderBy('neg_nama_negeri')->paginate(10);
            $data['negeri'] = $negeri;
        } 
        else {
            $query = Negeri::orderBy('neg_nama_negeri')->where(function($q) use ($carian_type, $carian_text){
                if(!empty($carian_type)){
                    if($carian_type=='Kod'){
                        $q->where('neg_kod_negeri','=', $carian_text);
                    }
                    else{
                        $q->where('neg_nama_negeri','like', "%{$carian_text}%");
                    }
                }
            });
            
            $negeri = $query->paginate(10);
            $data['negeri'] = $negeri;
        }       

        return view('utiliti/negeri.index', $data);
    }

    function simpan(Request $req){
        $neg_negeri_id = $req->neg_negeri_id;

        if(empty($neg_negeri_id)){
            $negeri = new Negeri();
            $negeri->neg_crtby = session('loginID');
            $negeri->neg_updby = session('loginID');
            $negeri->neg_log = date('Y-m-d H:i:s');
        }
        else{
            $negeri = Negeri::find($neg_negeri_id);
            $negeri->neg_updby = session('loginID');
        }

        $negeri->neg_kod_negeri = $req->neg_kod_negeri;
        $negeri->neg_nama_negeri = $req->neg_nama_negeri;
        $negeri->neg_nama_zone = $req->neg_nama_zone;
        $negeri->neg_maps_code = $req->neg_maps_code;
        $negeri->neg_status = $req->neg_status;

        // dd($negeri);
        $simpan = $negeri->save();
        if($simpan){
            $output='';
            $negeri = Negeri::paginate(10);
            $output .= '  
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <th class="text-center" width="5%">No.</th>
                        <th class="text-center" width="10%">Kod</th>
                        <th width="40%">Negeri</th>
                        <th width="10%">Zon</th>
                        <th class="text-center" width="10%">Kod Peta</th>
                        <th width="10%">Status</th>
                        <th class="text-center" width="15%">#</th>
                    </thead>
                    <tbody>
                ';
            $no = $negeri->firstItem();
            foreach($negeri as $neg){
                $output .= '                                                     
                    <tr>
                        <td class="text-center">'.$no++.'</td>
                        <td class="text-center">'.str_pad($neg->neg_kod_negeri,2,'0',STR_PAD_LEFT).'</td>
                        <td>'.$neg->neg_nama_negeri.'</td>
                        <td>'.$neg->neg_nama_zone.'</td>
                        <td class="text-center">'.$neg->neg_maps_code.'</td>
                        <td>'.statusAktif($neg->neg_status).'</td>                          
                        <td class="text-center">
                            <a href="#" id="'.$neg->neg_negeri_id.'" class="btn btn-xs btn-info edit_negeri" title="Kemaskini">
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
        $negeri = Negeri::find($req->neg_negeri_id);
        echo json_encode($negeri);
    }
}