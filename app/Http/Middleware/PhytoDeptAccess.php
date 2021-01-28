<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class PhytoDeptAccess
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
        if(Auth::guard('admin')->check() && Auth::guard('admin')->user()->dept_id != '3'){
            return redirect('/');

        }
        return $next($request);
    }
}
