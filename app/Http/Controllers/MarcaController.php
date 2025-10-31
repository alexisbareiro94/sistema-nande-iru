<?php

namespace App\Http\Controllers;

use App\Events\AuditoriaCreadaEvent;
use App\Models\Auditoria;
use Illuminate\Http\Request;
use App\Models\Marca;
use Illuminate\Support\Facades\Validator;

class MarcaController extends Controller
{
    public function store(Request $request){
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
            Auditoria::create([
                'created_by' => $request->user()->id,
                'entidad_type' => Marca::class,
                'entidad_id' => $marca->id,
                'accion' => 'Creación de marca'
            ]);
            AuditoriaCreadaEvent::dispatch(tenant_id());
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

    public function index(Request $request){
        try{
            $query = Marca::query();
            $search = $request->get('q');
            $marcas = $query->whereLike('nombre', "%$search%")
                            ->whereNot('id', 1)
                            ->get();
            
            return response()->json([
                'success' => true,
                'marcas' => $marcas,
            ]);
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
