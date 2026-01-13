<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\LicenseService;
use Illuminate\Support\Facades\Log;

class EnsureLicenseConfigured
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
        // Only run once per session to avoid performance issues
        if (!session()->has('license_configured_checked')) {
            $this->configureLicenseFromEnv();
            session()->put('license_configured_checked', true);
        }

        return $next($request);
    }

    /**
     * Ensure license is configured from environment variables
     *
     * @return void
     */
    protected function configureLicenseFromEnv()
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