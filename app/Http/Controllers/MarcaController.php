<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marca;
use Illuminate\Support\Facades\Validator;

class MarcaController extends Controller
{
    public function store(Request $request){
        // return response()->json([
        //     'nombre' => $request->nombre,
        // ]);
        $validate = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255|unique:marcas,nombre'
        ]);

        if($validate->fails()){
            return response()->json([
                'success' => false,
                'messages' => $validate->messages(),
            ], 400);
        }

        try{
            $marca = Marca::create($validate->validated());
            return response()->json([
                'success' => true,
                'data' => $marca,
            ], 201);
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
