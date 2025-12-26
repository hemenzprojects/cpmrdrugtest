<?php

namespace App\Services;

use App\License;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class LicenseService
{
    /**
     * Check if the evaluate report feature is licensed
     *
     * @return bool
     */
    public static function canEvaluateReports()
    {
        $license = License::where('feature', 'evaluate_report')->first();

        if (!$license) {
            return false;
        }

        // If license needs refresh, check API
        if ($license->needsRefresh()) {
            self::refreshLicense($license);
            $license->refresh(); // Reload from database
        }

        return $license->isValid();
    }

    /**
     * Refresh license from API
     *
     * @param License $license
     * @return void
     */
    public static function refreshLicense(License $license)
    {
        try {
            if (!$license->api_url) {
                Log::warning('License API URL not configured');
                return;
            }

            // Call the API with license key
            $response = Http::timeout(10)->get($license->api_url, [
                'license_key' => $license->license_key,
                'feature' => $license->feature,
            ]);

            if ($response->successful()) {
                $data = $response->json();

                // Update license based on API response
                $license->update([
                    'is_active' => $data['is_active'] ?? false,
                    'expires_at' => isset($data['expires_at']) ? Carbon::parse($data['expires_at']) : null,
                    'last_checked_at' => Carbon::now(),
                    'api_response' => json_encode($data),
                ]);

                Log::info('License refreshed successfully', [
                    'feature' => $license->feature,
                    'is_active' => $license->is_active,
                ]);
            } else {
                Log::error('License API returned error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                // On API error, mark as inactive for safety
                $license->update([
                    'is_active' => false,
                    'last_checked_at' => Carbon::now(),
                ]);
            }
        } catch (\Exception $e) {
            Log::error('License refresh failed', [
                'error' => $e->getMessage(),
                'feature' => $license->feature,
            ]);

            // On exception, mark as inactive for safety
            $license->update([
                'is_active' => false,
                'last_checked_at' => Carbon::now(),
            ]);
        }
    }

    /**
     * Create or update license configuration
     *
     * @param string $licenseKey
     * @param string $apiUrl
     * @param string $feature
     * @return License
     */
    public static function configureLicense($licenseKey, $apiUrl, $feature = 'evaluate_report')
    {
        $license = License::updateOrCreate(
            ['feature' => $feature],
            [
                'license_key' => $licenseKey,
                'api_url' => $apiUrl,
                'is_active' => false, // Will be activated after first API check
            ]
        );

        // Immediately check the license
        self::refreshLicense($license);

        return $license->fresh();
    }

    /**
     * Get license status information
     *
     * @return array
     */
    public static function getLicenseStatus()
    {
        $license = License::where('feature', 'evaluate_report')->first();

        if (!$license) {
            return [
                'exists' => false,
                'is_active' => false,
                'message' => 'No license configured',
            ];
        }

        return [
            'exists' => true,
            'is_active' => $license->isValid(),
            'expires_at' => $license->expires_at ? $license->expires_at->format('Y-m-d H:i:s') : null,
            'last_checked_at' => $license->last_checked_at ? $license->last_checked_at->format('Y-m-d H:i:s') : null,
            'message' => $license->isValid() ? 'License is active' : 'License is inactive or expired',
        ];
    }
}