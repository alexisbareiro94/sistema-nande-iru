<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Auditoria;

class CheckSessionTimeout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {            
        if (Auth::check()) {             
            session(['last_user_id' => Auth::id()]);
        }        
        $response = $next($request);

        // Si ya no está autenticado pero había un usuario antes
        if (!Auth::check() && session()->has('last_user_id')) {
            $userId = session('last_user_id');            
            Auditoria::create([
                'created_by' => $userId,
                'entidad_type' => \App\Models\User::class,
                'entidad_id' => $userId,
                'accion' => 'Cierre de sesión por inactividad',
            ]);

            // Limpiamos para no repetir
            session()->forget('last_user_id');
        }

        return $response;
    }
}
