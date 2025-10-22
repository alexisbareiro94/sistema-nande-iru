<?php

namespace App\Http\Controllers;

use App\Events\NotificacionEvent;
use Illuminate\Http\Request;
use App\Models\{Auditoria, User, PagoSalario};
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');        
        try {
            $users = User::where(function ($query) use ($q) {
                $query->whereLike('name', "%$q%")
                    ->orWhereLike('razon_social', "%$q%")
                    ->orWhereLike('ruc_ci', "%$q%");
            })
                ->with('compras')
                ->whereNotIn('role', ['admin', 'caja', 'personal']) 
                ->where('activo', true)
                ->orderByDesc('created_at')        
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
        $data['activo'] = true;
        try {
            $cliente = User::create($data);

            Auditoria::create([
                'created_by' => $request->user()->id,
                'entidad_type' => User::class,
                'entidad_id' => $cliente->id,                
                'accion' => 'Registro de cliente',
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
            ], 400);
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

    public function update(UpdateUserRequest $request, string $id)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $user = User::findOrFail($id);
            $user->update([
                'razon_social' => $data['razon_social'] ?? $user->razon_social,
                'ruc_ci' => $data['ruc_ci'] ?? $user->ruc_ci,
            ]);

            Auditoria::create([
                'created_by' => $request->user()->id,
                'entidad_type' => User::class,
                'entidad_id' => $user->id,
                'accion' => 'Actualización de cliente',
                'datos' => [
                    'Usuario ' => $user->name ?? $user->razon_social,
                ]
            ]);

            NotificacionEvent::dispatch('Actualización', 'Usuario Actualizado', 'blue');
            $data = $user->load('compras');            
            DB::commit();
            return response()->json([
                'message' => 'Usuario actualizado',
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => $e->getMessage(),
            ]);
        }
    }
}
