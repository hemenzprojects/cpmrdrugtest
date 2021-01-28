<?php

namespace App\Http\Middleware;

use Closure;
use Auth;


class DeptOneAccess
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
       // dd(Auth::guard('admin')->check() && Auth::guard('admin')->user()->dept_id != '1');
        if(Auth::guard('admin')->check() && Auth::guard('admin')->user()->dept_id != '1'){
            return redirect('/');
        }
        return $next($request);
    }
}
