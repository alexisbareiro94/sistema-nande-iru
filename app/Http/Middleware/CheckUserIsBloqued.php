<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserIsBloqued
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {        
        if(auth()->user()->is_blocked){
            auth()->logout();
            return redirect()->route('login')->with('error', 'Esta cuenta fue bloqueada');
        }
        return $next($request);
    }
}
