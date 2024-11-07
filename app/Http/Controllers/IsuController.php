<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Isu;
use App\Models\JenisIsu;
use Carbon\Carbon;

class IsuController extends Controller
{
    function senarai(){
        return view('isu.senarai');
    }

    function ajaxFormAdd($tanah_id){
        $data['tanahID'] = $tanah_id;
        $data['isu'] = new Isu();
        $data['jenisIsu'] = JenisIsu::where('isuet_status', '1')
                ->orderBy('isuet_sort')
                ->pluck('isuet_name', 'isuetype_id')
                ->prepend('--Sila Pilih--', '');
        return view('isu.form', $data);
    }

    function ajaxFormEdit($tanah_id, $isu_id){
        $data['tanahID'] = $tanah_id;
        $data['isu']  = Isu::find($isu_id);
        $data['jenisIsu'] = JenisIsu::where('isuet_status', '1')
                ->orderBy('isuet_sort')
                ->pluck('isuet_name', 'isuetype_id')
                ->prepend('--Sila Pilih--', '');
                
        return view('isu.form', $data);
    }

    function simpan(Request $req){
        $isue_id = $req->isue_id;
     
        if(!empty( $isue_id)){
            $isu = Isu::find($isue_id);
            // $isu->isue_status = $req->isue_status;
            $isu->isue_updby = session('loginID');
        }
        else{
            $isu = new Isu();
            $isu->isue_crtby = session('loginID');
            $isu->isue_updby = session('loginID');
        }
        $isu->isue_tanah_id = $req->tanah_id;
        $isu->isue_type_id = $req->isue_type_id;
        $isu->isue_desc = $req->isue_desc;
        $isu->isue_sdate = Carbon::createFromFormat('d/m/Y', $req->isue_sdate)->format('Y-m-d');
        $isu->isue_edate = Carbon::createFromFormat('d/m/Y', $req->isue_edate)->format('Y-m-d');

        // dd($isu);
        $simpan = $isu->save();
        if($simpan){
            return redirect('/tanah/view/'.encrypt($req->tanah_id))->with('msg', 'Maklumat Perkara Berbangkit berjaya di simpan');
        }        
    }

    function delete(Request $req){
        $isue_id = $req->delid;
        $isu = Isu::find($isue_id)->delete();
        if($isu){
            $output='';
            $lsisue = Isu::where('isue_tanah_id',  $req->tanah_id)->get();
            $no = 1;
            $padammsj = 'Anda pasti untuk padam';
            foreach($lsisue as $i){
                $output .= '                                                     
                    <tr>
                        <td class="text-center" width="5%">'.$no++.'</td>
                        <td width="15%">'.$i->jenis->isuet_name.'</td>
                        <td width="50%">'.$i->isue_desc.'</td>
                        <td width="10%">'.date('d/m/Y', strtotime($i->isue_sdate)).'</td>
                        <td width="10%">'.statusAktif($i->isue_status).'</td>
                        <td width="10%">
                            <a href="#" class="my-edit-isu" val="'.$i->isue_id.'" data-toggle="modal" data-target="#modal-fas">
                                <i class="far fa-edit"></i>
                            </a>
                            <a href="#" onclick="return confirm('.$padammsj.')" class="my-del-isu" val="'.$i->isue_id.'">
                                <i class="fas fa-trash text-danger"></i>
                            </a>
                        </td>
                    </tr>
                ';  
            }         
            echo $output;
        }
        else{
            echo 'ERROR';
        }            
    }
}
