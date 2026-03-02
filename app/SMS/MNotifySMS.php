<?php

namespace App\SMS;

use Illuminate\Support\Facades\Log;

class MNotifySMS
{
    /**
     * Send single SMS message via mNotify
     *
     * @param string $message
     * @param string $phoneNumber
     * @return object|null
     */
    public static function sendMessage($message, $phoneNumber)
    {
        try {
            $apiKey = config('sms.mnotify.api_key');
            $senderId = config('sms.mnotify.sender_id');
            $apiUrl = config('sms.mnotify.api_url');

            if (!$apiKey) {
                Log::error('mNotify API key not configured');
                return null;
            }

            // Format phone number (ensure it starts with country code)
            $formattedPhone = self::formatPhoneNumber($phoneNumber);

            // Prepare request payload
            $payload = [
                'key' => $apiKey,
                'recipient' => [$formattedPhone],
                'sender' => $senderId,
                'message' => $message,
                'is_schedule' => false,
                'schedule_date' => '',
            ];

            $headers = [
                'Content-Type: application/json',
                'Accept: application/json',
            ];

            $ch = curl_init($apiUrl);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            curl_close($ch);

            if ($error) {
                Log::error('mNotify SMS cURL error', [
                    'error' => $error,
                    'phone' => $formattedPhone,
                ]);
                return null;
            }

            $result = json_decode($response);

            // Log the response for debugging
            Log::info('mNotify SMS sent', [
                'phone' => $formattedPhone,
                'http_code' => $httpCode,
                'response' => $result,
                'status' => $result->code ?? 'unknown',
            ]);

            return $result;

        } catch (\Exception $e) {
            Log::error('mNotify SMS exception', [
                'error' => $e->getMessage(),
                'phone' => $phoneNumber,
            ]);
            return null;
        }
    }

    /**
     * Send bulk SMS messages via mNotify
     *
     * @param string $message
     * @param array|string $phoneNumbers - Can be array or comma-separated string
     * @return object|null
     */
    public static function sendBulkMessage($message, $phoneNumbers)
    {
        try {
            $apiKey = config('sms.mnotify.api_key');
            $senderId = config('sms.mnotify.sender_id');
            $apiUrl = config('sms.mnotify.api_url');

            if (!$apiKey) {
                Log::error('mNotify API key not configured');
                return null;
            }

            // Handle both array and comma-separated string
            if (is_string($phoneNumbers)) {
                $phoneNumbers = array_map('trim', explode(',', $phoneNumbers));
            }

            // Format all phone numbers
            $formattedPhones = array_map([self::class, 'formatPhoneNumber'], $phoneNumbers);

            // Prepare request payload
            $payload = [
                'key' => $apiKey,
                'recipient' => $formattedPhones,
                'sender' => $senderId,
                'message' => $message,
                'is_schedule' => false,
                'schedule_date' => '',
            ];

            $headers = [
                'Content-Type: application/json',
                'Accept: application/json',
            ];

            $ch = curl_init($apiUrl);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            curl_close($ch);

            if ($error) {
                Log::error('mNotify Bulk SMS cURL error', [
                    'error' => $error,
                    'recipients_count' => count($formattedPhones),
                ]);
                return null;
            }

            $result = json_decode($response);

            // Log the response for debugging
            Log::info('mNotify Bulk SMS sent', [
                'recipients_count' => count($formattedPhones),
                'http_code' => $httpCode,
                'response' => $result,
                'status' => $result->code ?? 'unknown',
            ]);

            return $result;

        } catch (\Exception $e) {
            Log::error('mNotify Bulk SMS exception', [
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }

    /**
     * Format phone number to ensure it has country code (Ghana: 233)
     *
     * @param string $phoneNumber
     * @return string
     */
    private static function formatPhoneNumber($phoneNumber)
    {
        // Remove any spaces, dashes, or special characters
        $phone = preg_replace('/[^0-9]/', '', $phoneNumber);

        // If starts with 0, replace with 233
        if (substr($phone, 0, 1) === '0') {
            $phone = '233' . substr($phone, 1);
        }

        // If doesn't start with 233, prepend it
        if (substr($phone, 0, 3) !== '233') {
            $phone = '233' . $phone;
        }

        return $phone;
    }

    /**
     * Get human-readable status message from mNotify response code
     *
     * @param string|int $code
     * @return string
     */
    public static function getStatusMessage($code)
    {
        $statusMessages = [
            '1000' => 'Success - Message sent successfully',
            '1002' => 'SMS sending failed. Might be due to server error or other reason',
            '1003' => 'Insufficient SMS balance',
            '1004' => 'Invalid API key',
            '1005' => 'Invalid recipient phone number',
            '1006' => 'Invalid Sender ID. Sender ID must not be more than 11 characters',
            '1007' => 'Message scheduled for later delivery',
            '1008' => 'Empty message',
            '1009' => 'mNotify service temporarily unavailable',
        ];

        return $statusMessages[$code] ?? "Unknown status code: {$code}";
    }
}