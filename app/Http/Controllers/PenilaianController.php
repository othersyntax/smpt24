<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penilaian;

class PenilaianController extends Controller
{
    function ajaxFormAdd($tanah_id){
        $data['tanahID'] = $tanah_id;
        $data['penilaian'] = new Penilaian();
        return view('penilaian.form', $data);
    }

    function ajaxFormEdit($tanah_id, $penilaian_id){
        $data['tanahID'] = $tanah_id;
        $data['penilaian']  = Penilaian::find($penilaian_id);
        // echo $a->penilaian_id;
        // dd($data);
        return view('penilaian.form', $data);
    }

    function simpan(Request $req){
        $penilaian_id = $req->penilaian_id;
     
        if(!empty( $penilaian_id)){
            $pen = Penilaian::find($penilaian_id);
            $pen->pen_update_by = session('loginID');
        }
        else{
            $pen = new Penilaian();
            $pen->pen_create_by = session('loginID');
            $pen->pen_update_by = session('loginID');
        }
        $pen->pen_tanah_id = $req->tanah_id;
        $pen->pen_jenis = $req->pen_jenis;
        $pen->pen_tahun = $req->pen_tahun;
        $pen->pen_nilai = $req->pen_nilai;
        $pen->save();
        return redirect('/tanah/view/'.encrypt($req->tanah_id))->with('msg', 'Maklumat Penilaian berjaya di simpan');
    } 
    
    function delete(Request $req){
        $penilaian_id = $req->delid;
        $pen = Penilaian::find($penilaian_id)->delete();
        if($pen){
            $output='';
            $penliti = Penilaian::where('pen_tanah_id',  $req->tanah_id)->get();
            $no = 1;
            $padammsj = 'Anda pasti untuk padam';
            foreach($penliti as $pen){
                $output .= '                                                     
                    <tr>
                        <td class="text-center">'.$no++.'</td>
                        <td>'.$pen->pen_jenis.'</td>
                        <td>'.$pen->pen_tahun.'</td>
                        <td class="text-right">'.number_format($pen->pen_nilai, 2).'</td>
                        <td class="text-center">
                            <a href="#" class="my-edit-pen" val="'.$pen->penilaian_id.'" data-toggle="modal" data-target="#modal-fas">
                                <i class="far fa-edit"></i>
                            </a>
                            <a href="#" onclick="return confirm('.$padammsj.')" class="my-del-pen" val="'.$pen->penilaian_id.'">
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
