<?php

return [
    'provider' => '46elks',

    'providers' => [
        '46elks' => [
            'service_url' => 'https://api.46elks.com/a1/sms',
            'username' => env( 'SMS_USER', '' ),
            'password' => env( 'SMS_PASSWORD', '' ),
            'dry_run' => env( 'SMS_DEV', '1' ),
            'callback' => env( 'APP_URL' ) . '/callback/sms'
        ]
    ]
];
