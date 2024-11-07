<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Models\Dokumen;

class DokumenController extends Controller
{
    function ajaxFormAdd($tanah_id){
        $data['tanahID'] = $tanah_id;
        $data['dokumen'] = new Dokumen();
        return view('dokumen.form', $data);
    }

    function simpan(Request $req){
        $document_id = $req->document_id;

        $data = $req->all();
        $rules = [
            'doc_desc'      => 'required',
            'doc_type'      => 'required',
            'doc_location' => 'required'

        ];

        $msg = [
            'doc_desc.required'     => 'Sila masukkan Nama Dokumen',
            'doc_type.required'     => 'Sila pilih Jenis Dokumen',
            'doc_location.required'     => 'Sila pilih Dokumen untuk di muatnaik',
        ];

        $v = Validator::make($data, $rules, $msg);
        if($v->fails()){
            return back()->with('msg', 'Maklumat dokumen gagal di simpan');
        }
        else{
            if(!empty( $document_id)){
                $doc = Dokumen::find($document_id);
            }
            else{
                $doc = new Dokumen();
                $doc->doc_create_by = session('loginID');
            }
            $doc->doc_tanah_id = $req->tanah_id;
            $doc->doc_desc = $req->doc_desc;
            $doc->doc_type = $req->doc_type;
            // $doc->doc_name = $req->
            $file = $req->file('doc_location');
            $ext = $file->getClientOriginalExtension();
            $nama_doc = $req->tanah_id.'-'.$req->doc_type.'.'.$ext;
            $path = $req->file('doc_location')->storeAs('files/', $nama_doc);              
            
            //$doc->doc_name = $nama_doc;
            $doc->doc_location = $nama_doc;
            $doc->doc_create_by = session('loginID'); //Read from session
            $doc->save();
            return redirect('/tanah/view/'.encrypt($req->tanah_id))->with('msg', 'Maklumat Dokumen berjaya di simpan');
        }
    }
}
