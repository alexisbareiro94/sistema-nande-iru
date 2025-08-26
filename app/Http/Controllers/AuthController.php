<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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

    public function register_view(Request $request){
        return view('Auth.register');
    }

    public function register(Request $request){
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'name.required' => 'completar el campo nombre',
            'email.required' => 'completar el campo email',
            'email.unique' => 'El email ya esta registrado',
            'password.required' => 'completar el campo password',
            'password.min' => 'completar el campo password',
            'password.confirmed' => 'confirmar el campo password',
        ]);

        if($validate->fails()){
            return back()->with('error', $validate->messages()->first());
        }
        try{
            User::create($validate->validated());
            return redirect()->route('login')->with('success', 'Registro exitoso');
        }catch (\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}
