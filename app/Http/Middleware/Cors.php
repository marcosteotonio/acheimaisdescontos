<?php

namespace App\Http\Middleware;

use Closure;

class Cors
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
        return $next($request)
            ->header('Access-Control-Allow-Origin', '*')            
            ->header('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, DELETE, HEAD')
            ->header('Access-Control-Allow-Headers', 'Origin, Content-Type, Accept, Authorization, X-Request-With, x-xsrf-token, x-csrf-token')
            ->header('Access-Control-Allow-Credentials', 'true');
    }
}
