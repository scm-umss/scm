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
        //dd(auth()->user()->roles()->slug);
        //if (auth()->user()->tieneRol(['admin'])) {
        //   return $next($request);
        //}
    }
}
