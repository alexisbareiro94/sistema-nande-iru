<?php

namespace App\Http\Controllers;

use App\Models\Auditoria;
use Illuminate\Http\Request;
use App\Models\Distribuidor;
use Illuminate\Support\Facades\Validator;
use App\Events\AuditoriaCreadaEvent;

class DistribuidorController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');
        $query = Distribuidor::query();

        $distribuidores = $query->where('nombre', 'like', "%$q%")
            ->orWhere('ruc', 'like', "%$q%")
            ->orWhere('celular', 'like', "%$q%")
            ->orWhere('direccion', 'like', "%$q%")
            ->orderBy('id', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $distribuidores
        ]);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'nombre' => 'required|unique:distribuidores,nombre',
            'ruc' => 'nullable|string|unique:distribuidores,ruc',
            'celular' => 'nullable|numeric',
            'direccion' => 'nullable|string',
        ], [
            'nombre.required' => 'El nombre del distribuidor es obligatorio',
            'ruc.unique' => 'El RUC ya se encuentra registrado',
            'ruc.string' => 'El RUC debe ser una cadena de texto',
            'celular.numeric' => 'El celular debe ser un numero',
            'direccion.string' => 'La dirección debe ser una cadena de texto',
        ]);

        if ($validate->fails()) {
            return response()->json([
                "success" => false,
                'messages' => $validate->messages()
            ], 400);
        }

        try {
            $distribuidor = Distribuidor::create($validate->validated());

            Auditoria::create([
                'created_by' => $request->user()->id,
                'entidad_type' => Distribuidor::class,
                'entidad_id' => $distribuidor->id,
                'accion' => 'Creación de distribuidor',                
            ]);
            AuditoriaCreadaEvent::dispatch(tenant_id());
            return response()->json([
                'success' => true,
                'message' => 'Distribuidor creado correctamente',
                'data' => $distribuidor
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
