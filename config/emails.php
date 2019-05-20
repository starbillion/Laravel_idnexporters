<?php

return [

    'authentication' => [
        'register'       => [
            'subject' => 'Verify Your Account',
            'body'    => 'Please verify your email.',
            'button'  => 'Verify',
        ],

        'reset_password' => [
            'subject' => 'Reset Password',
            'body'    => 'You are receiving this email because we received a password reset request for your account.',
            'button'  => 'Reset Password',
        ],
    ],

    'user'           => [
        'approve' => [
            'subject' => 'Your account has been approved',
            'body'    => 'Your account has been approved. Not sure what to do next? Start by adding products, or explore all the features in your dashboard.',
            'button'  => 'Go to Dashboard',
        ],
        'reject'  => [
            'subject' => 'Your account has been rejected',
            'body'    => 'Your account has been rejected.',
        ],
    ],

    'product'        => [
        'approve' => [
            'subject' => 'Your product has been approved',
            'body'    => 'Your product has been approved.',
            'button'  => 'Go to Dashboard',
        ],
        'reject'  => [
            'subject' => 'Your product has been rejected',
            'body'    => 'Your product has been rejected.',
        ],
    ],

    'package'        => [
        'request' => [
            'subject' => 'Package Request',
            'body'    => 'We are pleased to receive your recent order with IDNExporters. Our team is currently reviewing your order. We will contact you shortly. Your membership will be upgraded once the payment is settled.',
        ],
        'confirm' => [
            'subject' => 'Package Request Confirmed',
            'body'    => 'Your request has been confirmed. Thank you for your trust using our services.',
        ],
    ],

    'contact'        => [
        'thank_you' => [
            'subject' => 'Thank You!',
            'body'    => 'The introduction to the notification.',
        ],
    ],

    'admin'          => [
        'new_member'          => [
            'subject'    => 'New Member',
            'body'       => 'New member joined IDNExporters!',
            'button'     => 'View',
            'recipients' => 'andrewwwtp@gmail.com, w.kristories@gmail.com, ferdianjahja@gmail.com',
        ],
        'new_product'         => [
            'subject'    => 'New Product',
            'body'       => 'New product post',
            'button'     => 'View',
            'recipients' => null,
        ],
        'new_package_request' => [
            'subject'    => 'New Package Request',
            'body'       => 'New package request',
            'button'     => 'View',
            'recipients' => 'andrewwwtp@gmail.com, w.kristories@gmail.com',
        ],
    ],

];
