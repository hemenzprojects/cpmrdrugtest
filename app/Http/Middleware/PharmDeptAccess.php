<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class PharmDeptAccess
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
        
        if(Auth::guard('admin')->user()->dept_id == '2' && Auth::guard('admin')->user()->user_type_id == '1'  || Auth::guard('admin')->user()->user_type_id == '2'){

        return $next($request);
        }
        return back();
         
    }
}
