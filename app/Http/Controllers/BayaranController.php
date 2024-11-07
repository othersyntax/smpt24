<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bayaran;
use Validator;
use Carbon\Carbon;

class BayaranController extends Controller
{
    function ajaxFormAdd($tanah_id){
        $data['tanahID'] = $tanah_id;
        $data['bayaran'] = new Bayaran();
        return view('bayaran.form', $data);
    }

    function ajaxFormEdit($tanah_id, $bayaran_id){
        $data['tanahID'] = $tanah_id;
        $data['bayaran'] = Bayaran::find($bayaran_id);
        return view('bayaran.form', $data);
    }

    function simpan(Request $req){
        $bayaran_id = $req->bayaran_id;

        if(!empty( $bayaran_id)){
            $bayar = Bayaran::find($bayaran_id);
        }
        else{
           $bayar = new Bayaran(); 
        }
        
        $bayar->bayar_tanah_id = $req->tanah_id;
        $bayar->bayar_year = $req->bayar_year;
        $bayar->bayar_amaun = $req->bayar_amaun;
        $bayar->bayar_date = Carbon::createFromFormat('d/m/Y', $req->bayar_date)->format('Y-m-d');
        $bayar->bayar_desc = $req->bayar_desc;
        
        $bayar->bayar_created_by = session('loginID'); //Read from session
        // $bayar->bayar_created_at = Carbon::now(); //Read from session
        $bayar->bayar_updated_by = session('loginID'); //Read from session
        // $bayar->bayar_updated_at = Carbon::now(); //Read from session

        $data = $req->all();
        $rules = [
            'bayar_year'      => 'required',
            'bayar_amaun'      => 'required',
            'bayar_date' => 'required',
            'bayar_desc' => 'required'
        ];

        $msg = [
            'bayar_year.required'    => 'Sila masukkan tahun',
            'bayar_amaun.required'   => 'Sila masukkan amaun bayaran',
            'bayar_date.required'    => 'Sila masukkan tarikh bayaran',
            'bayar_desc.required'    => 'Sila masukkan keterangan'
        ];
        // dd($bayar);
        $v = Validator::make($data, $rules, $msg);
        if($v->fails()){
            return back()->with('msg', 'Maklumat bayariliti gagal di simpan');
        }
        else{
            $bayar->save();
            return redirect('/tanah/view/'.encrypt($req->tanah_id))->with('msg', 'Maklumat bayaran berjaya di simpan');
        }
    }

    function delete(Request $req){
        $bayaran_id = $req->delid;
        $bayar = Bayaran::find($bayaran_id)->delete();
        if($bayar){
            $output='';
            $bayaran = Bayaran::where('bayar_tanah_id',  $req->tanah_id)->get();
            $no = 1;
            $padammsj = 'Anda pasti untuk padam';
            foreach($bayaran as $b){
                $output .= '                                                     
                    <tr>
                        <td class="text-center" width="5%">'.$no++.'</td>
                        <td>'.$b->bayar_year.'</td>
                        <td>'.$b->bayar_desc.'</td>
                        <td>'.date('d/m/Y', strtotime($b->bayar_date)).'</td>
                        <td class="text-right">'.number_format($b->bayar_amaun,2).'</td>
                        <td>
                            <a href="#" class="my-edit-isu" val="'.$b->bayaran_id.'" data-toggle="modal" data-target="#modal-fas">
                                <i class="far fa-edit"></i>
                            </a>
                            <a href="#" onclick="return confirm('.$padammsj.')" class="my-del-isu" val="'.$b->bayaran_id.'">
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
