<?php

return [

    /*
    |--------------------------------------------------------------------------
    | OTP Token Type
    |--------------------------------------------------------------------------
    |
    | The type of the otp token.
    |
    | Supported: "numeric", "alpha_numeric"
    |
    */

    'token_type' => env('OTP_TOKEN_TYPE', 'numeric'),

    /*
    |--------------------------------------------------------------------------
    | OTP Token Length
    |--------------------------------------------------------------------------
    |
    | The length of the otp token.
    |
    */

    'token_length' => env('OTP_TOKEN_LENGTH', 6),

    /*
    |--------------------------------------------------------------------------
    | OTP Token Validity
    |--------------------------------------------------------------------------
    |
    | The validity of the otp token in minutes.
    |
    */

    'token_validity' => env('OTP_TOKEN_VALIDITY', 2),

];
