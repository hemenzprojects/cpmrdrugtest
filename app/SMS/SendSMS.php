<?php
namespace App\SMS;

/**
 * SendSMS - Wrapper class for SMS sending
 * Now uses mNotify as the default provider
 * Legacy Wirepick code kept for reference
 */
class SendSMS
{
    /**
     * Send SMS message using configured provider
     * Now defaults to mNotify
     *
     * @param string $message
     * @param string $phoneNumber
     * @return mixed
     */
    public static function sendMessage($message, $phoneNumber)
    {
        $provider = config('sms.default', 'mnotify');

        if ($provider === 'mnotify') {
            return MNotifySMS::sendMessage($message, $phoneNumber);
        } elseif ($provider === 'wirepick') {
            return self::sendViaWirepick($message, $phoneNumber);
        }

        // Default to mNotify if provider not recognized
        return MNotifySMS::sendMessage($message, $phoneNumber);
    }

    /**
     * Legacy Wirepick SMS sending method
     * Kept for backward compatibility
     *
     * @param string $message
     * @param string $phoneNumber
     * @return void
     */
    private static function sendViaWirepick($message, $phoneNumber)
    {
        try {
            $url = config('sms.wirepick.api_url');
            $param = array(
                'phone' => '233' . substr($phoneNumber, 1),
                'from' => config('sms.wirepick.from'),
                'client' => config('sms.wirepick.client'),
                'password' => config('sms.wirepick.password'),
                'text' => urlencode($message)
            );

            $rest = '';
            foreach ($param as $key => $value) {
                $rest .= $key . '=' . $value . '&';
            }
            $rest = substr($rest, 0, -1);
            $newurl = $url . '?' . $rest;

            $ch = curl_init($newurl);
            curl_setopt($ch, CURLOPT_POST, 0);
            curl_setopt($ch, CURLOPT_VERBOSE, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $result = curl_exec($ch);
            $error = curl_error($ch);
            curl_close($ch);
        } catch (\Exception $e) {
            // Silent fail for backward compatibility
        }
    }
}