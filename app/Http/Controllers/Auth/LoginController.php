<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengguna;
use App\Models\PusatTanggungjawab;
use Session;
use Hash;
use DB;

class LoginController extends Controller
{
    public function login(){
        return view('auth.login1');
    }

    public function authLogin(Request $req){
        $rules = [
            'email'=>'required | email ',
            'password'=>'required | min:6'        
        ];

        $message = [
            'email.required' => 'Sila masukkan emel',
            'email.email' => 'Sila masukkan emel yang tepat',
            'password.required' => 'Sila masukkan katalaluan',
            'password.min' => 'Katalaluan sekurang-kurangnya 6 aksara'
        ];
        $req->validate($rules, $message);

        // dd($req);
        $peng = Pengguna::where('user_email', $req->email)
                        ->where('user_status', 1)
                        ->first();

        // dd($peng);

        if($peng){
            if(Hash::check($req->password, $peng->user_pswd)){
                // $daerah = PusatTanggungjawab::find($peng->user_jkn, ['ptj_kod_daerah']);
                $req->session()->put([
                    'loginID'=>$peng->user_id,
                    'loginName'=>$peng->user_name,
                    'loginNokp'=>$peng->user_nokp,
                    'loginRole'=>$peng->user_role,
                    'loginImage'=>$peng->user_image,
                    'loginState'=>$peng->namaPTJ->bandar->ban_kod_negeri,
                    'loginDaerah'=>$peng->namaPTJ->bandar->ban_kod_daerah,
                    'loginBandar'=>$peng->namaPTJ->ptj_kod_bandar
                ]);
                return redirect('dashboard');
            }
            else{
                return back()->with('gagal', 'Katalalulan salah!!');
            }
        }
        else{
            return back()->with('gagal', 'Emel tidak wujud/ Akaun tidak Aktif');
        }
        return view('auth.login');
    }

    public function updatePass(){
        $pass = Hash::make('123456');
        DB::table('tbluser')
       ->update(['user_pswd'=>$pass]);
        return redirect('/auth/login');
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|string|email',
    //         'password' => 'required|string',
    //     ]);

    //     $credentials = $request->only('email', 'password');

    //     if (Auth::attempt($credentials)) {
    //         return redirect()->intended('home');
    //     }

    //     return redirect('login')->with('error', 'Oppes! You have entered invalid credentials');
    // }

    public function logout() {
        if(Session::has('loginID')){
            Session::pull('loginID');
            Session::pull('loginName');
            Session::pull('loginNokp');
            Session::pull('loginRole');
            Session::pull('loginImage');
            Session::pull('loginJKN');
            Session::pull('loginState');
            Session::pull('loginDaerah');
            Session::pull('loginBandar');
            return redirect('/');
        }      
    }

    // public function home()
    // {

    //   return view('home');
    // }
}
