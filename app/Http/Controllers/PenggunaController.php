<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Pengguna;
use App\Models\UserModul;

class PenggunaController extends Controller
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
            $data['user']= $this->getPenggunaData();
        } 
        else {
            $query = DB::table('tbluser')
                        ->leftJoin('tblptj', 'tbluser.user_jkn','=', 'tblptj.ptj_id')
                        ->select('tbluser.*', 'tblptj.ptj_nama')
                        ->orderBy('tbluser.user_status', 'ASC')
                        ->orderBy('tbluser.user_name', 'ASC')
                        ->where(function($q) use ($carian_type, $carian_text){
                if(!empty($carian_type)){
                    if($carian_type=='Negeri'){
                        $q->where('ddsa_kod_negeri.neg_nama_negeri','like', "%{$carian_text}%");
                    }
                    else if($carian_type=='NoKP'){
                        $q->where('tbluser.user_nokp','like', "%{$carian_text}%");
                    }
                    else if($carian_type=='Nama'){
                        $q->where('tbluser.user_name','like', "%{$carian_text}%");
                    }
                    else{
                        if($carian_text=='Pentadbir')
                            $carian_text=1;
                        else if($carian_text=='Pegawai')
                            $carian_text=2;
                        else
                            $carian_text=3;
                        $q->where('tbluser.user_role','=', $carian_text);
                    }
                }
            });
            
            $user = $query->paginate(20);
            $data['user'] = $user;
        }       

        return view('utiliti/pengguna.index', $data);
    }

    function simpan(Request $req){
        $user_id = $req->user_id;  
        if(empty($user_id)){
            $user = new Pengguna();
            $user->user_pswd = Hash::make($user->user_nokp);
            $user->user_name = $req->user_name;
            $user->user_nokp = $req->user_nokp;
            $user->user_email = $req->user_email;
            $user->user_role = $req->user_role;
            $moduls = $req->user_modul;
            
            $user->user_jkn = $req->user_jkn;       
            $user->user_crtby = session('loginID');
            $user->user_updby = session('loginID');
            $user->user_crtdate = date('Y-m-d H:i:s');

            $simpan = $user->save();

            // dd($simpan);
            if($simpan){
                //insert User Modul ///Guna nanti yg ni utk masuk multiple modul
                foreach($moduls as $mdl){
                    $UModul = new UserModul;
                    $UModul->um_user_id = $user->user_id;
                    $UModul->um_modul_id = $mdl;
                    $UModul->um_created_by=session('loginID');
                    $UModul->um_updated_by=session('loginID');
                    $UModul->save();
                }
            }

        }
        else{
            $user = Pengguna::find($user_id);
            $user_id = $req->user_id;
            if(!empty($req->user_pass1)){
                $user->user_pswd = Hash::make($user->user_pass1);                
            }
            $user->user_name = $req->user_name;
            $user->user_nokp = $req->user_nokp;
            $user->user_email = $req->user_email;
            $user->user_jkn = $req->user_jkn;
            $user->user_role = $req->user_role;
            $user->user_status = $req->user_status;            
            $user->user_updby = session('loginID');
            $simpan = $user->save();
        }

        return redirect('utiliti/pengguna/senarai');
    }

    function modul(Request $req){
        $user_module_id = $req->user_module_id;
        if(empty($user_module_id)){
            $um = new UserModul();
            $um->um_created_by = session('loginID');
            $um->um_updated_by = session('loginID');
        }
        else{
            $um = UserModul::find($user_module_id);
            $um->um_updated_by = session('loginID');
        }
        $um->um_user_id = $req->user_id;
        $um->um_modul_id = $req->um_modul_id;
        $um->um_status = $req->um_status;
    
        $simpan = $um->save();
    
        return redirect('utiliti/pengguna/ubah/'.$req->user_id);
    }

    function tambah(){
        return view('utiliti/pengguna.tambah');
    }

    function getmodul(Request $req){
        $moduldata = UserModul::find($req->user_module_id);
        echo json_encode($moduldata);
    }

    function ubah(Request $req){
        $user = Pengguna::find($req->user_id);
        $data['user'] = $user;
        return view('utiliti/pengguna.ubah', $data);
    }

    function papar(Request $req){
        return view('utiliti/pengguna.ubah');
    }

    function setKatalaluan(Request $req){
        $user = Pengguna::find($req->user_id_setpass);

        $user->user_pswd = Hash::make($user->user_nokp);
        $user->user_updby = session('loginID');
        $simpan = $user->save();

        if($simpan)
            return true;
        else
            return false;
    }

    function getPenggunaData(){
        $user = DB::table('tbluser')
                ->leftJoin('tblptj', 'tbluser.user_jkn','=', 'tblptj.ptj_id')
                ->select('tbluser.*', 'tblptj.ptj_nama')
                ->orderBy('tbluser.user_name')
                ->paginate(20);
        return $user;
    }
}
