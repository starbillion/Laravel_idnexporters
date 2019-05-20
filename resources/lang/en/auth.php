<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
     */

    'failed'                   => 'These credentials do not match our records.',
    'throttle'                 => 'Too many login attempts. Please try again in :seconds seconds.',

    'register_as'              => 'Register as:',
    'seller_account'           => 'Seller Account (Indonesia Only)',
    'buyer_account'            => 'Buyer Account',
    'agreement'                => 'By clicking Register, you confirm that you have <a href="' . route('public.page.show', ['slug' => 'tos']) . '" target="_blank">read the terms and conditions</a>, that you understand and agree to be bound by ' . config('app.name') . '.',

    'check_email_verification' => 'Check your inbox and click on the link in the email to verify your address. If you do not receive any verification email, please check your spam folder.',
];
