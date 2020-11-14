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

        // if (auth()->user()->roles[0]->slug == 'admin') {
        //     return $next($request);
        // }else{
        //     return redirect('/');
        // }
        
        if (auth()->user()->tieneRol(['admin'])) {
          return $next($request);
        }else {
            return redirect('/');
        }
    }
}
