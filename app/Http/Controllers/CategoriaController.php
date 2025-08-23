<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriaController extends Controller
{
    public function store(Request $request){
        $validate = Validator::make($request->all(),[
           'nombre' => 'required|unique:categorias,nombre',
        ],[
            'nombre.required' => 'El categoria es requerido',
            'nombre.unique' => 'La Categoria ya existe',
        ]);

        if($validate->fails()){
            return response()->json($validate->errors(), 400);
        }

        try{
            $categoria = Categoria::create([
                'nombre' => $request->nombre,
            ]);

            return response()->json([
                'success' => true,
                'categoria' => $categoria
            ], 201);

        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'error' => 'ta mal',
            ], 500);
        }
    }

}
