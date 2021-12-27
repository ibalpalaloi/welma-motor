<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;


class AuthController extends Controller
{
    //

    public function sign_in(){

        return view('auth.sign_in');
    }

    public function post_sign_in(Request $request){

        \Validator::make($request->all(),[
            "username" => "required",
            "password" => "required"
        ])->validate();
        

        $remember_me = $request->has('remember_me') ? true : false;

        if(Auth::attempt(['username' => $request->username, 'password' => $request->password], $remember_me)){

    
            $user = User::where('username', $request->username)->first();
            $user->last_sign_in = date("Y-m-d H:i:s");
            $user->save();

            return redirect('/');
        }
        else{

            return redirect('/sign_in');
        }


    }

    public function sign_out(){
    
        Auth::logout();
        return redirect('/sign_in');
    }

    public function ganti_password(Request $request){
        
        $validation = \Validator::make($request->all(),[
            'password_pengguna_baru' => 'required',
        ])->validate();    

        $user = User::find(Auth::user()->id);
        $user->password = \Hash::make($request->get('password_pengguna_baru'));
        $user->save();

        return redirect()->back();
    }
}
