<?php

return [
    /*
    |--------------------------------------------------------------------------
    | AskEva API Base URL
    |--------------------------------------------------------------------------
    |
    | Here you may specify the base URL for the AskEva WhatsApp API.
    |
    */
    'base_url' => env('ASKEVA_BASE_URL', 'https://backend.askeva.io/v1/message/send-message'),

    /*
    |--------------------------------------------------------------------------
    | AskEva API Token
    |--------------------------------------------------------------------------
    |
    | Your unique AskEva authentication token.
    |
    */
    'token' => env('ASKEVA_TOKEN'),

    /*
    |--------------------------------------------------------------------------
    | AskEva Webhook Verify Token
    |--------------------------------------------------------------------------
    |
    | Your custom verification token used to verify the webhook challenge.
    |
    */
    'webhook_verify_token' => env('ASKEVA_WEBHOOK_VERIFY_TOKEN', env('ASKEVA_TOKEN')),
];
