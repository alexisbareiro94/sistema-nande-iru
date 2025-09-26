<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class GestionUsersController extends Controller
{
    public function index_view(){
        return view('usuarios.index');
    }

    public function store(Request $request){        
        try{
            $validated = $request->validate([
                'role' => 'required',
                'name' => 'required',
                'password' => 'required|min:8',
                'telefono' => 'required',
                'estado' => 'required',   
                'email' => 'required|email',    
                'salario' => 'required|numeric',    
                'estado' => 'required',
            ]);

            User::create($validated);

            return back()->with('success', 'esta bien :D');
        }catch(\Exception $e){  
            return back()->with('error', $e->getMessage());
        }
    }
}