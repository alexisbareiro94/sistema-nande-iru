<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CajaMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {           
        if($request->user()->role != 'caja' && $request->user()->role != 'admin' && $request->user()->role != 'personal'){
            return redirect('login')->with('error', 'No estas autorizado');
        }
        return $next($request);
    }
}
