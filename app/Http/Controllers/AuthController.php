<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login_view(){
        return view('Auth.login');
    }

    public function login(Request $request){     
        $validate = $request->validate([
            'email' => 'required|exists:users,email',
            'password' => 'required'
        ], [
            'email.required' => 'completar el campo email',
            'email.exists' => 'El email no esta registrado',
            'password.*' => 'completar el campo contraseña'
        ]);

        if(Auth::attempt($validate)){
            return redirect()->route('home');
        }else{
            return back()->with('error');
        }
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }

}
