<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(\Auth::check()) {
            if(\Auth::user()->is_admin ==1)
            {
                return $next($request);
                
            }
            return redirect('/dashboard')->with('error', 'Tu usuario no tiene acceso a lo que quieres acceder.'); 
        } else {
            return redirect('/login'); 
            
        }
        return $next($request);

    }
}
