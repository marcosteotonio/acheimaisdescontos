<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminAuth
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
            return redirect('/admin/login');
        }else{
            if(Auth::user()->tipo != null){ // tipo do admin eh null
                return redirect('/admin/login');
            }
        }

        return $next($request);
    }
}
