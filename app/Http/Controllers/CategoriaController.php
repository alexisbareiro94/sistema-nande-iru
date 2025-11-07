<?php

namespace App\Http\Controllers;

use App\Events\AuditoriaCreadaEvent;
use App\Models\Auditoria;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoriaController extends Controller
{
    public function store(Request $request)
    {
        $tenantId = tenant_id();
        $validate = Validator::make($request->all(), [
            'nombre' => ['required', Rule::unique('categorias')->where(function($q) use ($tenantId) {
                $q->where('tenant_id', $tenantId);
            })],
        ], [
            'nombre.required' => 'El categoria es requerido',
            'nombre.unique' => 'La Categoria ya existe',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validate->messages(),
            ], 400);
        }

        try {
            $categoria = Categoria::create([
                'nombre' => $request->nombre,
            ]);

            Auditoria::create([
                'created_by' => $request->user()->id,
                'entidad_type' => Categoria::class,
                'entidad_id' => $categoria->id,
                'accion' => 'Creación de categoría',                
            ]);
            AuditoriaCreadaEvent::dispatch(tenant_id());
            return response()->json([
                'success' => true,
                'categoria' => $categoria
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function index(Request $request)
    {
        try {
            $query = Categoria::query();
            $q = $request->query('q');

            $categorias = $query->whereLike('nombre', "%$q%")
                ->whereNot('id', 1)
                ->get();

            return response()->json([
                'success' => true,
                'categorias' => $categorias,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
