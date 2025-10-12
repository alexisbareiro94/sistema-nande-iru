<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Auditoria, User, PagoSalario};
use App\Http\Requests\StoreUserRequest;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');
        try {
            $users = User::where(function ($query) use ($q) {
                $query->whereLike('name', "%{$q}%")
                    ->orWhereLike('ruc_ci', "%{$q}%");
            })
                ->whereNotIn('role', ['admin', 'caja'])
                ->get();

            return response()->json([
                'success' => true,
                'users' => $users,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        try {
            $cliente = User::create($data);

            Auditoria::create([
                'created_by' => $request->user()->id,
                'entidad_type' => User::class,
                'entidad_id' => $cliente->id,
                'accion' => 'Registro de cliente'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Cliente Agregado con éxito',
                'cliente' => $cliente,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function show(string $id)
    {
        try {
            $pagosSalario = PagoSalario::whereHas('user', function ($q) use ($id) {
                return $q->where('id', $id);
            })
                ->orderByDesc('created_at')
                ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
                ->with('user')
                ->first();            

            return response()->json([
                'success' => true,
                'data' => $pagosSalario ?? User::find($id),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
