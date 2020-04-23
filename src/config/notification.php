<?php

return [
    'mail' => [
        'mail_from_address' => env('MAIL_FROM_ADDRESS') ? env('MAIL_FROM_ADDRESS') : env('MAIL_USERNAME'),
        'email_name' => env('YOUR_EMAIL_NAME'),
    ],
    'line' => [
        'line_bearer' => env('LINE_BEARER') ? explode(',', env('LINE_BEARER')) : [],
    ],
    'nexmo' => [
        'username' => env('NEXMO_USERNAME', 'Vonage'),
    ],
];
