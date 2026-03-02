<?php

namespace App\SMS;

/**
 * SendbulkSMS - Wrapper class for bulk SMS sending
 * Now uses mNotify as the default provider
 * Legacy EaziSend code kept for reference
 */
class SendbulkSMS
{
    /**
     * Send bulk SMS using configured provider
     * Now defaults to mNotify
     *
     * @param string $message
     * @param string|array $phoneNumber - Can be comma-separated string or array
     * @return object|null
     */
    public static function sendBulkMessage($message, $phoneNumber)
    {
        $provider = config('sms.default', 'mnotify');

        if ($provider === 'mnotify') {
            return MNotifySMS::sendBulkMessage($message, $phoneNumber);
        } elseif ($provider === 'eazisend') {
            return self::sendViaEaziSend($message, $phoneNumber);
        }

        // Default to mNotify if provider not recognized
        return MNotifySMS::sendBulkMessage($message, $phoneNumber);
    }

    /**
     * Legacy EaziSend bulk SMS sending method
     * Kept for backward compatibility
     *
     * @param string $message
     * @param string $phoneNumber
     * @return object|null
     */
    private static function sendViaEaziSend($message, $phoneNumber)
    {
        $senderName = config('sms.eazisend.sender_name');
        $clientId = config('sms.eazisend.client_id');
        $apiKey = config('sms.eazisend.api_key');
        $headers = ['Content-Type: application/json'];
        $baseurl = config('sms.eazisend.api_url');

        $details =
            'clientId=' . $clientId . '&' .
            'phoneNumbers=' . $phoneNumber . '&' .
            'messages=' . $message . '&' .
            'senderName=' . $senderName . '&' .
            'apiKey=' . $apiKey;

        parse_str($details, $details);
        $details = json_encode($details);

        $ch = curl_init($baseurl);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $details);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $server_output = curl_exec($ch);
        $err = curl_error($ch);

        curl_close($ch);

        if ($err) {
            return null;
        } else {
            $resp = json_decode($server_output);
            return $resp;
        }
    }

    /**
     * Get human-readable status message from response code
     * Compatible with both mNotify and EaziSend codes
     *
     * @param string|int $result
     * @return string
     */
    public static function status($result)
    {
        // Delegate to MNotifySMS for consistent status messages
        return MNotifySMS::getStatusMessage($result);
    }
}