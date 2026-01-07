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

        // Auto-configure license if not set up yet
        $this->ensureLicenseConfigured();

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

    /**
     * Ensure license is configured from environment variables
     *
     * @return void
     */
    protected function ensureLicenseConfigured()
    {
        $licenseKey = env('LICENSE_KEY');
        $apiUrl = env('LICENSE_API_URL');

        // Skip if no configuration in .env
        if (!$licenseKey || !$apiUrl) {
            Log::debug('No license configuration found in .env');
            return;
        }

        // Check if license already exists in database
        $existingLicense = \App\License::where('feature', 'evaluate_report')->first();

        // Only auto-configure if:
        // 1. No license exists, OR
        // 2. License exists but API URL/key has changed
        if (!$existingLicense ||
            $existingLicense->api_url !== $apiUrl ||
            $existingLicense->license_key !== $licenseKey) {

            Log::info('Auto-configuring license from .env', [
                'api_url' => $apiUrl,
                'reason' => !$existingLicense ? 'no_license' : 'config_changed',
            ]);

            LicenseService::configureLicense($licenseKey, $apiUrl, 'evaluate_report');
        }
    }
}
