<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisHakMilik;

class HakMilikController extends Controller
{
    function index(Request $req){
        return view('utiliti/hakmilik.index');
    }

    public function dataHakmilik(Request $req){
        
        if($req->isMethod('post')) {
            $carian_type = $req->carian_type;
            $carian_text = $req->carian_text;
            // dd($req);
            if(!empty($carian_type)){
                $query = JenisHakMilik::where(function($q) use ($carian_type, $carian_text){
                    if(!empty($carian_type)){
                        if($carian_type=='Jenis'){
                            $q->where('jenishm_desc','like', "%{$carian_text}%");
                        }
                        else{
                            if($carian_text=='Aktif' || $carian_text=='aktif')
                                $keyid = 1;
                            else
                            $keyid = 2;

                            $q->where('jenishm_status','=', $keyid);
                        }
                    }
                });
                $hakmilik = $query->get();
            }
            else{
                $hakmilik = JenisHakMilik::all();
                return response()->json([
                    'hakmilik'=>$hakmilik,
                ]); 
            }

            return response()->json([
                'hakmilik'=>$hakmilik,
            ]); 
        }
        else{
            $hakmilik = JenisHakMilik::all();
            return response()->json([
                'hakmilik'=>$hakmilik,
            ]); 
        }
    }

    public function ubah(Request $req){
        $hakmilik = JenisHakMilik::find($req->jenishm_id);
        echo json_encode($hakmilik);
    }

    function simpan(Request $req){
        $jenishm_id = $req->jenishm_id;

        if(empty($jenishm_id)){
           $hakmilik = new JenisHakMilik();            
           $hakmilik->jenishm_created_by = session('loginID');
           $hakmilik->jenishm_updated_by = session('loginID');
        }
        else{
           $hakmilik = JenisHakMilik::find($jenishm_id);
           $hakmilik->jenishm_updated_by = session('loginID');
        }

       $hakmilik->jenishm_desc = $req->jenishm_desc;
       $hakmilik->jenishm_sort = $req->jenishm_sort;
       $hakmilik->jenishm_status = $req->jenishm_status;

        $simpan =$hakmilik->save();
        if($simpan){
            return response()->json([
                'status'=>200,
                'message'=>'Maklumat Berjaya di Simpan.'
            ]);
        }
        else{
            return response()->json([
                'status'=>404,
                'message'=>'Maklumat Gagal di Simpan.'
            ]);
        }
    }
}
