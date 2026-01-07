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
     * @param bool $forceRefresh Force refresh even if recently checked
     * @return bool Returns true if refresh was successful
     */
    public static function refreshLicense(License $license, $forceRefresh = false)
    {
        try {
            if (!$license->api_url) {
                Log::warning('License API URL not configured', ['feature' => $license->feature]);
                return false;
            }

            // Skip if recently checked and not forcing
            if (!$forceRefresh && !$license->needsRefresh()) {
                Log::info('License check skipped - recently checked', [
                    'feature' => $license->feature,
                    'last_checked_at' => $license->last_checked_at,
                ]);
                return true;
            }

            Log::info('Checking license API', [
                'feature' => $license->feature,
                'api_url' => $license->api_url,
            ]);

            // Call the API - try with params first, then without
            $response = Http::timeout(10)->get($license->api_url, [
                'license_key' => $license->license_key,
                'feature' => $license->feature,
            ]);

            if ($response->successful()) {
                $data = $response->json();

                Log::info('License API response received', [
                    'feature' => $license->feature,
                    'response' => $data,
                ]);

                // Extract is_active from response
                $isActive = isset($data['is_active']) ? (bool)$data['is_active'] : false;

                // Parse expiration date if provided
                $expiresAt = null;
                if (isset($data['expires_at']) && $data['expires_at']) {
                    try {
                        $expiresAt = Carbon::parse($data['expires_at']);
                    } catch (\Exception $e) {
                        Log::warning('Failed to parse expires_at', ['value' => $data['expires_at']]);
                    }
                }

                // Update license with fresh data
                $updateData = [
                    'is_active' => $isActive,
                    'expires_at' => $expiresAt,
                    'last_checked_at' => Carbon::now(),
                    'api_response' => json_encode($data),
                ];

                $license->update($updateData);

                // Force reload from database to ensure we have latest data
                $license->refresh();

                Log::info('License updated successfully', [
                    'feature' => $license->feature,
                    'is_active' => $license->is_active,
                    'expires_at' => $license->expires_at,
                    'last_checked_at' => $license->last_checked_at,
                ]);

                return true;
            } else {
                Log::error('License API returned error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'url' => $license->api_url,
                ]);

                // On API error, mark as inactive for safety
                $license->update([
                    'is_active' => false,
                    'last_checked_at' => Carbon::now(),
                ]);
                $license->refresh();

                return false;
            }
        } catch (\Exception $e) {
            Log::error('License refresh failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'feature' => $license->feature,
            ]);

            // On exception, mark as inactive for safety
            $license->update([
                'is_active' => false,
                'last_checked_at' => Carbon::now(),
            ]);
            $license->refresh();

            return false;
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
        Log::info('Configuring license', [
            'feature' => $feature,
            'api_url' => $apiUrl,
        ]);

        $license = License::updateOrCreate(
            ['feature' => $feature],
            [
                'license_key' => $licenseKey,
                'api_url' => $apiUrl,
                'is_active' => false, // Will be activated after first API check
            ]
        );

        // Immediately check the license with force refresh
        $success = self::refreshLicense($license, true);

        Log::info('License configuration complete', [
            'feature' => $feature,
            'refresh_success' => $success,
            'is_active' => $license->fresh()->is_active,
        ]);

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
                'notification_message' => null,
            ];
        }

        // Extract notification message object from API response
        $notificationMessage = null;
        if ($license->api_response) {
            $apiData = json_decode($license->api_response, true);
            $notificationMessage = $apiData['notification_message'] ?? null;
        }

        return [
            'exists' => true,
            'is_active' => $license->isValid(),
            'expires_at' => $license->expires_at ? $license->expires_at->format('Y-m-d H:i:s') : null,
            'last_checked_at' => $license->last_checked_at ? $license->last_checked_at->format('Y-m-d H:i:s') : null,
            'api_response' => $license->api_response,
            'message' => $license->isValid() ? 'License is active' : 'License is inactive or expired',
            'notification_message' => $notificationMessage,
        ];
    }

    /**
     * Force refresh license from API (useful for debugging)
     *
     * @return array
     */
    public static function forceRefresh()
    {
        $license = License::where('feature', 'evaluate_report')->first();

        if (!$license) {
            return [
                'success' => false,
                'message' => 'No license configured',
            ];
        }

        $success = self::refreshLicense($license, true);

        return [
            'success' => $success,
            'license' => $license->fresh(),
            'status' => self::getLicenseStatus(),
        ];
    }
}
