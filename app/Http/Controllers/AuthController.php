<?php

namespace App\Http\Controllers;

use App\Events\AuditoriaCreadaEvent;
use App\Events\AuthEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\{User, Auditoria};
use App\Events\NotificacionEvent;

class AuthController extends Controller
{
    public function __construct()
    {
        crear_caja();
    }

    public function index()
    {
        return view('home.index');
    }

    public function login_view()
    {
        return view('Auth.login');
    }

    public function login(Request $request)
    {
        try {
            $validate = $request->validate([
                'email' => 'required|exists:users,email',
                'password' => 'required'
            ], [
                'email.required' => 'completar el campo email',
                'email.exists' => 'El email no esta registrado',
                'password.*' => 'completar el campo contraseña'
            ]);

            if (Auth::attempt($validate)) {
                $user = Auth::user();
                $user->update([
                    'en_linea' => true,
                ]);
                Auditoria::create([
                    'created_by' => $user->id,
                    'entidad_type' => User::class,
                    'entidad_id' => $user->id,
                    'accion' => 'Inicio sesion'
                ]);
                AuditoriaCreadaEvent::dispatch();
                AuthEvent::dispatch($user, 'login');
                NotificacionEvent::dispatch('Nuevo Inicio de Sesion', "$user->name inicio sesion", 'blue');
                if ($user->role == 'personal' || $user->role == 'caja') {
                    return redirect()->route('caja.index');
                }
                if ($user->role === 'cliente') {
                    session()->flush();
                }
                return redirect()->route('home');
            } else {;
                NotificacionEvent::dispatch('Intento de inicio de sesion', " de: " . $validate['email'], 'orange');
                return back()->with('error');
            }
        } catch (\Exception $e) {
            NotificacionEvent::dispatch('Intento de inicio de sesion', " de: " . $request->email, 'orange');
            return back()->with('error', $e->getMessage());
        }
    }

    public function register_view()
    {
        return view('Auth.register');
    }

    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'name.required' => 'completar el campo nombre',
            'email.required' => 'completar el campo email',
            'email.unique' => 'El email ya esta registrado',
            'password.required' => 'completar el campo password',
            'password.min' => 'completar el campo password',
            'password.confirmed' => 'confirmar el campo password',
        ]);

        if ($validate->fails()) {
            return back()->with('error', $validate->messages()->first());
        }
        try {
            $user = User::create($validate->validated());
            Auditoria::create([
                'created_by' => $request->user()->id,
                'entidad_type' => User::class,
                'entidad_id' => $user->id,
                'accion' => 'Creacion de usuario'
            ]);     
            AuditoriaCreadaEvent::dispatch();       
            return redirect()->route('login')->with('success', 'Registro exitoso');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function logout()
    {
        try {
            $user = Auth::user();
            $user->update([
                'ultima_conexion' => now(),
                'en_linea' => false,
            ]);
            Auditoria::create([
                'created_by' => $user->id,
                'entidad_type' => User::class,
                'entidad_id' => $user->id,
                'accion' => 'Cierre de sesion'
            ]);
            AuditoriaCreadaEvent::dispatch();
            Auth::logout();
            AuthEvent::dispatch($user, 'logout');
            NotificacionEvent::dispatch('Cierre de Sesion', "$user->name a cerrado sesion", 'blue');
            return redirect('/');
        } catch (\Exception) {
            return back()->with('error', 'Intente de vuelta');
        }
    }
}
