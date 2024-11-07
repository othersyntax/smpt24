<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    function papar(){
        $user = Pengguna::find(session('loginID'));
        $data['user'] = $user;
        return view('profile.ubah', $data);
    }

    function simpan(Request $req){
        // ddd($req);
        // return $req->file('user_image')->store('profile');
        if(!empty(session('loginID'))){
            $user = Pengguna::find(session('loginID'));
            if(!empty($req->user_pass1) && !empty($req->user_pass2)){
                $user->user_pswd = Hash::make($user->user_pass1);                
            }
            $user->user_name = $req->user_name;
            $user->user_nokp = $req->user_nokp;
            $user->user_email = $req->user_email;

            if($req->hasFile('user_image')){
                // return $req->file('user_image')->store('profile');
                $file = $req->file('user_image');
                $ext = $file->getClientOriginalExtension();
                $img_name = $req->user_nokp.'-profile.'.$ext;
                $path = $req->file('user_image')->storeAs('profile', $img_name);              
                
                $user->user_image = $path;

            }
            // return $req->file('user_image')->store('profile');
            $user->user_updby = session('loginID');
            $simpan = $user->save();

            if($simpan){
                return redirect('profile/papar');
            }
        }
        else{
            return redirect('auth/logout');
        }        
    }
}
