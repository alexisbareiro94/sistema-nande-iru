<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Events\NotificacionEvent;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {        
        if ($request->user()->role != 'admin') {
            $user = auth()->user();                  
            NotificacionEvent::dispatch(
                'ALERTA!',
                "Intento de acceso no autorizado, por: " . ($user->name ?? $request->ip()) . " en " . $request->fullUrl(),
                'red', tenant_id()
            );
            return redirect()->route('login')->with('error', 'no tienes permisos');
        }
        return $next($request);
    }
}
