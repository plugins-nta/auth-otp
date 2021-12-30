<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Global setting with expiration time of OTP
    |--------------------------------------------------------------------------
    | This option is in minutes
    |
    */
    'lifeTime' => 3,

    /*
    |--------------------------------------------------------------------------
    | Global setting with OTP code length
    |--------------------------------------------------------------------------
    */
    'length' => 6,

    /*
    |--------------------------------------------------------------------------
    | Channels send otp
    |--------------------------------------------------------------------------
    |
    | This option controls the OTP gửi sending channel
    | There are 2 methods of sending OTP supported: "mail", "SMS"
    |
    */
    'channels' => 'mail',

    /*
    |--------------------------------------------------------------------------
    | SMS driver
    |--------------------------------------------------------------------------
    |
    | This option controls how the SMS is sent through the 3rd app
    | Supported: "twilio", "nexmo",
    |
    */
    'sms_driver' => 'twilio',

    /*
    |--------------------------------------------------------------------------
    | Global setting driver send SMS
    |--------------------------------------------------------------------------
    |
    | This option is set when doing OTP sending with SMS
    | If you do not send OTP with SMS, please skip this part
    |
    */
    'twilio' => [
        'account_sid' => env('TWILIO_ACCOUNT_SID', null),
        'auth_token' => env('TWILIO_AUTH_TOKEN', null),
        'sms_from' => env('TWILIO_SMS_FROM', null),
    ],
    'nexmo' => [
        'account_sid' => env('NEXMO_KEY', null),
        'auth_token' => env('NEXMO_SECRET', null),
        'sms_from' => env('NEXMO_SMS_FROM', null),
    ],
];
