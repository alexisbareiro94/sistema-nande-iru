<?php

namespace App\Http\Controllers;

use App\Models\{Auditoria, User, PagoSalario};
use Illuminate\Http\Request;
use App\Http\Requests\UpdatePersonalRequest;
use App\Events\AuditoriaCreadaEvent;
use App\Http\Requests\UpdateUserRequest;
use App\Jobs\MailRestablecerPassJob;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class GestionUsersController extends Controller
{
    public function index_view()
    {
        try {

            $tenantId = tenant_id();
            $users = User::whereNotIn('role', ['cliente', 'admin'])
                ->where('tenant_id', $tenantId)
                ->where('activo', true)
                ->with(['pagoSalarios', 'ultima_venta'])
                ->get();

            $salarios = User::whereNotIn('role', ['cliente', 'admin'])
                ->where('tenant_id', $tenantId)
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
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
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
            ->where('tenant_id', tenant_id())
            ->whereNot('role', 'cliente')
            ->get();

        return response()->json([
            'data' => $users,
        ]);
    }

    //function para que un admin cree un usuario
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'role' => 'required',
                'name' => 'required',
                'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'],
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
            AuditoriaCreadaEvent::dispatch(tenant_id());
            return back()->with('success', 'Usuario creado');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(string $id)
    {
        try {
            $user = User::whereNot('role', 'admin')
                ->where('tenant_id', tenant_id())
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
            User::where('tenant_id', tenant_id())->find($id)->update($data);
            Auditoria::create([
                'created_by' => $request->user()->id,
                'entidad_type' => User::class,
                'entidad_id' => $id,
                'accion' => 'Actualizacion de datos de personal'
            ]);
            AuditoriaCreadaEvent::dispatch(tenant_id());
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
            AuditoriaCreadaEvent::dispatch(tenant_id());
            return response()->json([
                'message' => 'Usuario eliminado',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    public function restablecer_pass(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'id' => 'required|exists:users,id'
        ]);

        if ($validated->fails()) {
            return back()->with('error', 'Selecciona un cliente');
        }
        $user = User::select('id', 'name')
            ->where('tenant_id', tenant_id())
            ->findOrFail($request->id);
        try {
            Auditoria::create([
                'created_by' => auth()->user()->id,
                'entidad_type' => User::class,
                'entidad_id' => $request->id,
                'accion' => 'Correo de recuperación de contraseña enviado',
                'datos' => [
                    'Usuario' => $user->name,
                ]
            ]);
            MailRestablecerPassJob::dispatch($request->id);
            return redirect()->back()->with('success', 'Correo de recuperación de contraseña enviada');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage(),);
        }
    }

    public function restablecer_pass_view(Request $request)
    {
        try {            
            $token = $request->query('token');              
            $data = json_decode(Crypt::decrypt($token));                        
            $id = $data->user_id;
            $expireDate = $data->expires_at;            
            if (Carbon::parse($expireDate)->isPast()) {
                return redirect()->route('login')->with('error', 'El enlace ya no es valido');
            }

            $user = User::findOrFail($id);
            return view('gestios-usuarios.restablecer-pass.index', [
                'user' => $user,
            ]);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function update_admin(UpdateUserRequest $request, string $id)
    {           
        try{
            $data = $request->validated();
            $user = User::findOrFail($id);
            
            if(!Hash::check($data['actual_password'], $user->password)){
                return redirect()->back()->with('error', 'La contraseña no coincide');
            }

            User::findOrFail($id)
                ->update($data);

            return redirect()->back()->with('success', 'Usuario Actualizado');
        }catch(\Exception $e){
            throw new \Exception($e->getMessage());
            // return redirect()->back('error', 'Hubo un error, inténtelo nuevamente');
        }
    }
}
