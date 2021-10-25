<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
}
