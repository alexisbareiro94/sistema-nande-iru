<?php

namespace App\Http\Controllers;

use App\Events\NotificacionEvent;
use Illuminate\Http\Request;
use App\Models\{Auditoria, User, PagoSalario};
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');
        $tenantId = tenant_id();        
        try {
            $users = User::where(function ($query) use ($q) {
                $query->whereLike('name', "%$q%")
                    ->orWhereLike('razon_social', "%$q%")
                    ->orWhereLike('ruc_ci', "%$q%");
            })
                ->with('compras')
                ->where('activo', true)
                ->where('tenant_id', $tenantId)
                ->whereNotIn('role', ['admin', 'caja', 'personal'])
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
                'data' => $pagosSalario ?? User::where('tenant_id', tenant_id())->find($id),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }

    //clientes
    public function update(UpdateUserRequest $request, string $id)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            dd($data);
            $user = User::where('tenant_id', tenant_id())->findOrFail($id);
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

            NotificacionEvent::dispatch('Actualización', 'Usuario Actualizado', 'blue', tenant_id());
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

    public function reset_password(Request $request, string $id)
    {
        DB::beginTransaction();
        try {
            $userId = Crypt::decrypt($id);
            $user = User::where('tenant_id', tenant_id())->findOrFail($userId);            
            $validated = Validator::make($request->all(), [
                'password' => 'required|confirmed|min:6'
            ]);

            if ($validated->fails()) {
                return redirect()->back()->with('error', $validated->messages());
            }
            $user->update([
                'password' => $request->password,
            ]);

            Auditoria::create([
                'created_by' => $user->id,
                'entidad_type' => User::class,
                'entidad_id' => $user->id,
                'accion' => 'Contraseña cambiada',
                'datos' => [
                    'Usuario: ' => $user->name ?? $user->razon_social,
                ]
            ]);            
            DB::commit();
            return redirect()->route('login')->with('success', 'Contraseña cambiada');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return redirect()->route('login')->with('error', 'Ocurrio un error');
        }
    }
}
