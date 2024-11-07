<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fasiliti;
use App\Models\Tanah;
use Validator;
use Illuminate\Support\Carbon;

class FasilitiController extends Controller
{
    function ajaxFormAdd($tanah_id){
        $data['tanahID'] = $tanah_id;
        $data['fasiliti'] = new Fasiliti();
        return view('fasiliti.form', $data);
    }

    function ajaxFormEdit($tanah_id, $fasiliti_id){
        $data['tanahID'] = $tanah_id;
        $data['fasiliti'] = Fasiliti::find($fasiliti_id);
        return view('fasiliti.form', $data);
    }

    // function papar($fasiliti_id){

    // }

    function simpan(Request $req){
        $fasiliti_id = $req->fasiliti_id;

        if(!empty( $fasiliti_id)){
            $fas = Fasiliti::find($fasiliti_id);
        }
        else{
           $fas = new Fasiliti(); 
        }
        
        $fas->fas_tanah_id = $req->tanah_id;
        $fas->fas_desc = $req->fas_desc;
        $fas->fas_guna = $req->fas_guna;
        // dd($fas);
        if($req->fas_guna =='Keseluruhan'){
            $sizedata = Tanah::find($req->tanah_id, ['tanah_luas', 'tanah_luas_unit']);
                // ->pluck('tanah_luas', 'tanah_luas_unit');
            // dd($sizedata);
            $fas->fas_size = $sizedata->tanah_luas;
            $fas->fas_size_unit = $sizedata->tanah_luas_unit;  
        }
        else{
            $fas->fas_size = $req->fas_size;
            $fas->fas_size_unit = $req->fas_size_unit;
        }
        
        $fas->fas_created_by = 1; //Read from session
        // $fas->fas_created_at = Carbon::now(); //Read from session
        $fas->fas_updated_by = 1; //Read from session
        // $fas->fas_updated_at = Carbon::now(); //Read from session

        $data = $req->all();
        $rules = [
            'fas_desc'      => 'required'
            // 'fas_size'      => 'required',
            // 'fas_size_unit' => 'required'
        ];

        $msg = [
            'fas_desc.required'     => 'Sila masukkan Nama Fasiliti'
            // 'fas_size.required'     => 'Sila masukkan size',
            // 'fas_size_unit.required'    => 'Sila pilih unit ukuran saiz'
        ];

        $v = Validator::make($data, $rules, $msg);
        if($v->fails()){
            return back()->with('msg', 'Maklumat fasiliti gagal di simpan');
        }
        else{
            $fas->save();
            return redirect('/tanah/view/'.encrypt($req->tanah_id))->with('msg', 'Maklumat fasiliti berjaya di simpan');
        }
    }

    function delete(Request $req){
        $fasiliti_id = $req->delid;
        $fas = Fasiliti::find($fasiliti_id)->delete();
        if($fas){
            $output='';
            $fasliti = Fasiliti::where('fas_tanah_id',  $req->tanah_id)->get();
            $no = 1;
            $padammsj = 'Anda pasti untuk padam';
            foreach($fasliti as $fas){
                $output .= '                                                     
                    <tr>
                        <td class="text-center">'.$no++.'</td>
                        <td>'.$fas->fas_desc.'</td>
                        <td>'.$fas->fas_size.'</td>
                        <td class="text-center">
                            <a href="#" class="my-edit" val="'.$fas->fasiliti_id.'" data-toggle="modal" data-target="#modal-fas">
                                <i class="far fa-edit"></i>
                            </a>
                            <a href="#" onclick="return confirm('.$padammsj.')" class="my-del" val="'.$fas->fasiliti_id.'">
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
