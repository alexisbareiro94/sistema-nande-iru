<?php

namespace App\Http\Controllers;

use App\Models\{Auditoria, User, PagoSalario};
use Illuminate\Http\Request;
use App\Http\Requests\UpdatePersonalRequest;
use App\Events\AuditoriaCreadaEvent;

class GestionUsersController extends Controller
{
    public function index_view()
    {
        $users = User::whereNot('role', 'cliente')
            ->where('activo', true)
            ->with(['pagoSalarios', 'ultima_venta'])
            ->get();

        $salarios = User::whereNot('role', 'cliente')
            ->where('activo', true)
            ->selectRaw("sum(salario) as salario")
            ->first()->salario;

        $pagos = PagoSalario::whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->with('user')
            ->get();

        $auditorias = Auditoria::with('user')
            ->orderByDesc('created_at')
            ->get()
            ->take(3);

        return view('usuarios.index', [
            'users' => $users,
            'salarios' => $salarios,
            'pagos' => $pagos,
            'auditorias' => $auditorias,
        ]);
    }

    public function refresh_auditorias()
    {
        try {
            $auditorias = Auditoria::with('user')
                ->orderByDesc('created_at')
                ->get()
                ->take(3);

            return response()->json([
                'data' => $auditorias,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    public function index()
    {
        $users = User::whereNot('role', 'admin')
            ->whereNot('role', 'cliente')
            ->get();

        return response()->json([
            'data' => $users,
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'role' => 'required',
                'name' => 'required',
                'password' => 'required|min:8',
                'telefono' => 'required',
                'email' => 'required|email',
                'salario' => 'required|numeric',
                'activo' => 'required',
            ]);
            $validated['estado'] = true;
            $user = User::create($validated);
            Auditoria::create([
                'created_by' => $request->user()->id,
                'entidad_type' => User::class,
                'entidad_id' => $user->id,
                'accion' => 'Creacion de personal'
            ]);
            AuditoriaCreadaEvent::dispatch();
            return back()->with('success', 'Usuario creado');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(string $id)
    {
        try {
            $user = User::whereNot('role', 'admin')
                ->whereNot('role', 'cliente')
                ->where('id', $id)
                ->first();

            return response()->json([
                'success' => true,
                'data' => $user,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function update(UpdatePersonalRequest $request, string $id)
    {
        try {
            $data = $request->validated();
            User::find($id)->update($data);
            Auditoria::create([
                'created_by' => $request->user()->id,
                'entidad_type' => User::class,
                'entidad_id' => $id,
                'accion' => 'Actualizacion de datos de personal'
            ]);
            AuditoriaCreadaEvent::dispatch();
            return response()->json([
                'success' => true,
                'message' => 'Usuario actualizado',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function delete(string $id)
    {
        try {
            User::destroy($id);
            Auditoria::create([
                'created_by' => auth()->user()->id,
                'entidad_type' => User::class,
                'entidad_id' => $id,
                'accion' => 'Eliminacion de personal'
            ]);
            AuditoriaCreadaEvent::dispatch();
            return response()->json([
                'message' => 'Usuario eliminado',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }
    }
}
