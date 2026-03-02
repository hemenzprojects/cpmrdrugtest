<?php

return [

    /*
    |--------------------------------------------------------------------------
    | SMS Configuration
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for SMS services used
    | by your application. These values should be stored in .env file
    | for security and should not be committed to version control.
    |
    */

    // Default SMS Provider
    'default' => env('SMS_PROVIDER', 'mnotify'),

    // mNotify SMS Configuration (Current Provider)
    'mnotify' => [
        'sender_id' => env('MNOTIFY_SENDER_ID', 'CPMR-SID'),
        'api_key' => env('MNOTIFY_API_KEY'),
        'api_url' => env('MNOTIFY_API_URL', 'https://api.mnotify.com/api/sms/quick'),
    ],

    // Legacy: Wirepick SMS (SendSMS) - Deprecated
    'wirepick' => [
        'from' => env('SMS_FROM', 'CPMR-SID'),
        'client' => env('SMS_CLIENT'),
        'password' => env('SMS_PASSWORD'),
        'api_url' => env('SMS_API_URL', 'https://api.wirepick.com/httpsms/send'),
    ],

    // Legacy: EaziSend Bulk SMS (SendbulkSMS) - Deprecated
    'eazisend' => [
        'sender_name' => env('SMS_BULK_SENDER_NAME', 'CPMR SID'),
        'client_id' => env('SMS_BULK_CLIENT_ID'),
        'api_key' => env('SMS_BULK_API_KEY'),
        'api_url' => env('SMS_BULK_API_URL', 'https://eazisend.com/api/sms/bulk'),
    ],

];
