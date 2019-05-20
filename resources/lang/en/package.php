<?php

return [

    /**********************************************/

    'seller'                      => [
        'regular'  => [
            'name'        => 'Regular',
            'description' => 'FREE',
            'modal_title' => '',
            'detail'      => '',
            'features'    => [
                'company_logo'           => 'No Seller Company Logo',
                'company_banners'        => 'No Seller Company Banners',
                'public_page'            => 'No Seller public page',
                'products'               => 'Max. 5 Product Posts',
                'featured'               => 'Not placed in any featured places',
                'traffic'                => 'No traffic analysis',
                'exhibition_directories' => 'No access to exhibition directories',
                'discounts'              => 'No discounts on sponsor exhibitions',
            ],
        ],

        'option_1' => [
            'name'        => 'Option 1',
            'description' => 'Rp 7,000,000 / year',
            'modal_title' => 'Gold Membership Pricing',
            'detail'      => 'Rp 7,000,000 per year, paid in advance.',
            'features'    => [
                'company_logo'           => 'Company Logo',
                'company_banners'        => 'Company Banners',
                'public_page'            => 'Seller public page',
                'products'               => '50 Product Posts',
                'featured'               => 'Products placed in featured places',
                'traffic'                => 'Product traffic analysis',
                'exhibition_directories' => 'Access to Exhibition Directories',
                'discounts'              => 'Discount on raw space for sponsored exhibitions',
            ],
        ],

        'option_2' => [
            'name'        => 'Option 2',
            'description' => 'Rp 2,000 for each click (DP Rp. 2.000.000)',
            'modal_title' => 'Pay Per Click Membership',
            'detail'      => 'Rp 2,000,000 deposit. Rp 2,000 per click on your products.<br>When deposit is exhausted, your products will stop showing on featured places.',
            'features'    => [
                'company_logo'           => 'Company Logo',
                'company_banners'        => 'Company Banners',
                'public_page'            => 'Seller public page',
                'products'               => '30 Product Posts',
                'featured'               => 'Products placed in featured places',
                'traffic'                => 'Product traffic analysis',
                'exhibition_directories' => 'Access to Exhibition Directories',
                'discounts'              => 'Discount on raw space for sponsored exhibitions',
            ],
        ],

        'option_3' => [
            'name'        => 'Option 3',
            'description' => 'IDN Marketing Service',
            'modal_title' => '5% Agency Fee',
            'detail'      => 'We\'ll market your products for a fee :
            <ul>
                <li>5% for items below USD 3/pc</li>
                <li>3% for items above USD 3/pc</li>
            </ul>',
            'features'    => [
                'company_logo'    => 'Company Logo',
                'company_banners' => 'Company Banners',
                'public_page'     => 'Seller public page',
                'products'        => 'Unlimited Product Posts',
                'featured'        => 'Products placed in featured places',
                'traffic'         => 'Product traffic analysis',
                'fee'             => 'IDN Marketing Fee ranges from 3% to 5% depending on your product and price. Our IDN Marketing Service\'s Team will contact you for detail discussion.',
                'discounts'       => 'Discount on raw space for sponsored exhibitions',
            ],
        ],

    ],

    /**********************************************/

    'buyer'                       => [
        'regular' => [
            'name'        => 'Regular',
            'description' => 'FREE',
            'modal_title' => '',
            'detail'      => '',
            'features'    => [
                'show_contact'           => 'No Access to Seller\'s Phone & Email',
                'exhibition_directories' => 'No Access to Exhibition Directories',
            ],
        ],

        'paid'    => [
            'name'        => 'Paid Member',
            'description' => '$1,000 / year',
            'modal_title' => 'Upgrade Buyers Membership',
            'detail'      => 'Our services also include :
            <ul>
                <li>Business Matching Services</li>
                <li>Face to Face Meeting</li>
                <li>Factories Visit</li>
                <li>Market Survey</li>
                <li>Company Verification</li>
                <li>Promotion Services & Event Management</li>
                <li>Receive Updated News and Info About Trade Events</li>
            </ul>',
            'features'    => [
                'show_contact'           => 'Access to Seller\'s Phone & Email',
                'exhibition_directories' => 'Access to Exhibition Directories',
            ],
        ],

    ],

    /**********************************************/

    'modal_upgrade'               => 'Membership Application (:package)',
    'promo_coupon'                => 'Promo Coupon',
    'upgrade_note'                => 'An invoice will be generated to email@addres.com.<br>Your membership will be upgraded once the payment is complete.',
    'request'                     => 'Request',
    'upgrade_request'             => 'Upgrade Request',
    'company_logo'                => 'Company Logo',
    'company_banners'             => 'Company Banners',
    'promocode'                   => 'Coupon',
    'promocode_placeholder'       => 'Promo coupon code (optional)',
    'request_notification'        => 'A notification will be sent to us. We will contact you shortly. Your membership will be upgraded once the payment is settled.',
    'notification_store_success'  => 'Package requested. We will contact you shortly. Your membership will be upgraded once the payment is settled.',
    'notification_update_success' => 'Package has been updated.',
    'notification_cancel'         => 'If you want to cancel your request, please <a href="' . route('public.contact.create') . '">contact us</a>',
    'notification_coupon_error'   => 'Coupon is invalid!',
    'requested'                   => 'Requested',
    'confirm'                     => 'Confirm',
    'cancel'                      => 'Cancel',
    'current_package'             => 'Current',
    'requested_package'           => 'Requested',
    'requested_time'              => 'Request at',
    'need_delete_product'         => 'You can select this package after you delete some of your products. The maximum product quantity of this package is :quantity products.',
    'ended_notification_seller'   => 'Your membership has expired. Your public profile, products and any other posts will not be visible to the public.',
    'ended_notification_buyer'    => 'Your membership has expired. Your account will no longer have access Paid member features.',
    'renew'                       => 'Renew',
    'year'                        => 'Year',
    'years'                       => 'Years',
    'billing_agreement'           => 'By clicking Request, you confirm that you have <a href="' . route('public.page.show', ['slug' => 'tos']) . '" target="_blank">read the terms and conditions</a>, that you understand and agree to be bound by ' . config('app.name') . '.',

    'invoice'                     => [
        'footer_notes' => 'Thank you very much for doing business with us. We look forward to working with you again!',
        'confirmed'    => 'Confirmed',
        'unconfirmed'  => 'Unconfirmed',
    ],
];
