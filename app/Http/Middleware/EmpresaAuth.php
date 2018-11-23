<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class EmpresaAuth
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
        if(!Auth::user()){
            return redirect('/login');
        }else{
            if(Auth::user()->tipo != 0){ // tipo da empresa eh 0
                return redirect('/login');
            }
        }

        return $next($request);
    }
}
