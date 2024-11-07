<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisIsu;

class JenisIsuController extends Controller
{
    function index(Request $req){
        return view('utiliti/isu.index');
    }

    public function dataIsu(Request $req){
        
        if($req->isMethod('post')) {
            $carian_type = $req->carian_type;
            $carian_text = $req->carian_text;
            // dd($req);
            if(!empty($carian_type)){
                $query = JenisIsu::where(function($q) use ($carian_type, $carian_text){
                    if(!empty($carian_type)){
                        if($carian_type=='Jenis'){
                            $q->where('isuet_name','like', "%{$carian_text}%");
                        }
                        else{
                            if($carian_text=='Aktif' || $carian_text=='aktif')
                                $keyid = 1;
                            else
                            $keyid = 2;

                            $q->where('isuet_status','=', $keyid);
                        }
                    }
                });
                $jnsisu = $query->get();
            }
            else{
                $jnsisu = JenisIsu::all();
                return response()->json([
                    'jnsisu'=>$jnsisu,
                ]); 
            }

            return response()->json([
                'jnsisu'=>$jnsisu,
            ]); 
        }
        else{
            $jnsisu = JenisIsu::all();
            return response()->json([
                'jnsisu'=>$jnsisu,
            ]); 
        }
    }

    public function ubah(Request $req){
        $jnsisu = JenisIsu::find($req->isuetype_id);
        echo json_encode($jnsisu);
    }

    function simpan(Request $req){
        $isuetype_id = $req->isuetype_id;

        if(empty($isuetype_id)){
            $jnsisu = new JenisIsu();            
            $jnsisu->isuet_crtby = session('loginID');
            $jnsisu->isuet_updby = session('loginID');
            $jnsisu->isuet_created = date('Y-m-d H:i:s');
        }
        else{
            $jnsisu = JenisIsu::find($isuetype_id);
            $jnsisu->isuet_updby = session('loginID');
        }

        $jnsisu->isuet_name = $req->isuet_name;
        $jnsisu->isuet_sort = $req->isuet_sort;
        $jnsisu->isuet_status = $req->isuet_status;

        // dd($jnsisu);
        $simpan = $jnsisu->save();
        if($simpan){
            return response()->json([
                'status'=>200,
                'message'=>'Maklumat Jenis Isu Berjaya di Simpan.'
            ]);
        }
        else{
            return response()->json([
                'status'=>404,
                'message'=>'Maklumat Jenis Isu Berjaya di Simpan.'
            ]);
        }
    }
}
