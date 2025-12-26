<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\LicenseService;
use Illuminate\Support\Facades\Session;

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
        // Auto-configure license if not set up yet
        $this->ensureLicenseConfigured();

        // Check if evaluate report feature is licensed
        if (!LicenseService::canEvaluateReports()) {
            Session::flash('message', 'Evaluate Report feature is not licensed or has expired. Please contact support.');
            Session::flash('message_title', 'error');

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
            return;
        }

        // Check if license already exists in database
        $existingLicense = \App\License::where('feature', 'evaluate_report')->first();

        // Only auto-configure if:
        // 1. No license exists, OR
        // 2. License exists but API URL has changed
        if (!$existingLicense || $existingLicense->api_url !== $apiUrl) {
            LicenseService::configureLicense($licenseKey, $apiUrl, 'evaluate_report');
        }
    }
}
