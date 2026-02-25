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

    // Wirepick SMS (SendSMS)
    'from' => env('SMS_FROM', 'CPMR-SID'),

    'client' => env('SMS_CLIENT'),

    'password' => env('SMS_PASSWORD'),

    'api_url' => env('SMS_API_URL', 'https://api.wirepick.com/httpsms/send'),

    // mNotify Bulk SMS (SendbulkSMS)
    'bulk' => [
        'sender_name' => env('SMS_BULK_SENDER_NAME', 'CPMR'),
        'api_key' => env('SMS_BULK_API_KEY'),
        'api_url' => env('SMS_BULK_API_URL', 'https://api.mnotify.com/api/sms/quick'),
    ],

];
