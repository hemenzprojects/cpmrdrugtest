<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\LicenseService;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class CheckEvaluateLicense
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
        Log::info('CheckEvaluateLicense middleware triggered', [
            'route' => $request->path(),
            'method' => $request->method(),
        ]);

        // Check if evaluate report feature is licensed
        $canEvaluate = LicenseService::canEvaluateReports();

        Log::info('License check result', [
            'can_evaluate' => $canEvaluate,
            'route' => $request->path(),
        ]);

        if (!$canEvaluate) {
            Log::warning('License check failed - access denied', [
                'route' => $request->path(),
                'user' => auth('admin')->id() ?? 'guest',
            ]);

            Session::flash('messagetitle', 'error');
            Session::flash('message', 'Evaluate Report feature is not licensed or has expired. Please contact support.');

            return redirect()->back();
        }

        return $next($request);
    }
}
