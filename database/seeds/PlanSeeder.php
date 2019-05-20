<?php

use Illuminate\Database\Seeder;
use Gerardojbaez\LaraPlans\Models\Plan;
use Gerardojbaez\LaraPlans\Models\PlanFeature;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plans = [
            [
                'plan'     => [
                    'name'              => 'regular',
                    'description'       => '',
                    'type'              => 'seller',
                    'currency_id'       => 47,
                    'price'             => 0,
                    'interval'          => 'year',
                    'interval_count'    => 20,
                    'trial_period_days' => 0,
                    'promo'             => 0,
                    'sort_order'        => 1,
                ],
                'features' => [
                    [
                        'code'       => 'company_logo',
                        'value'      => false,
                        'sort_order' => 1,
                    ],
                    [
                        'code'       => 'company_banners',
                        'value'      => false,
                        'sort_order' => 2,
                    ],
                    [
                        'code'       => 'public_page',
                        'value'      => false,
                        'sort_order' => 3,
                    ],
                    [
                        'code'       => 'products',
                        'value'      => 5,
                        'sort_order' => 4,
                    ],
                    [
                        'code'       => 'featured',
                        'value'      => false,
                        'sort_order' => 5,
                    ],
                    [
                        'code'       => 'traffic',
                        'value'      => false,
                        'sort_order' => 6,
                    ],
                    [
                        'code'       => 'exhibition_directories',
                        'value'      => false,
                        'sort_order' => 7,
                    ],
                    [
                        'code'       => 'discounts',
                        'value'      => false,
                        'sort_order' => 8,
                    ],
                ],
            ],

            [
                'plan'     => [
                    'name'              => 'option_1',
                    'description'       => '',
                    'type'              => 'seller',
                    'currency_id'       => 47,
                    'price'             => 7000000,
                    'interval'          => 'year',
                    'interval_count'    => 1,
                    'trial_period_days' => 0,
                    'promo'             => 1,
                    'sort_order'        => 2,
                ],
                'features' => [
                    [
                        'code'       => 'company_logo',
                        'value'      => 'Y',
                        'sort_order' => 1,
                    ],
                    [
                        'code'       => 'company_banners',
                        'value'      => 'Y',
                        'sort_order' => 2,
                    ],
                    [
                        'code'       => 'public_page',
                        'value'      => 'Y',
                        'sort_order' => 3,
                    ],
                    [
                        'code'       => 'products',
                        'value'      => 50,
                        'sort_order' => 4,
                    ],
                    [
                        'code'       => 'featured',
                        'value'      => 'Y',
                        'sort_order' => 5,
                    ],
                    [
                        'code'       => 'traffic',
                        'value'      => 'Y',
                        'sort_order' => 6,
                    ],
                    [
                        'code'       => 'exhibition_directories',
                        'value'      => 'Y',
                        'sort_order' => 7,
                    ],
                    [
                        'code'       => 'discounts',
                        'value'      => 'Y',
                        'sort_order' => 8,
                    ],
                ],
            ],

            [
                'plan'     => [
                    'name'              => 'option_2',
                    'description'       => '',
                    'type'              => 'seller',
                    'currency_id'       => 47,
                    'price'             => 0,
                    'interval'          => 'year',
                    'interval_count'    => 20,
                    'trial_period_days' => 0,
                    'promo'             => 0,
                    'sort_order'        => 3,
                ],
                'features' => [
                    [
                        'code'       => 'company_logo',
                        'value'      => 'Y',
                        'sort_order' => 1,
                    ],
                    [
                        'code'       => 'company_banners',
                        'value'      => 'Y',
                        'sort_order' => 2,
                    ],
                    [
                        'code'       => 'public_page',
                        'value'      => 'Y',
                        'sort_order' => 3,
                    ],
                    [
                        'code'       => 'products',
                        'value'      => 30,
                        'sort_order' => 4,
                    ],
                    [
                        'code'       => 'featured',
                        'value'      => 'Y',
                        'sort_order' => 5,
                    ],
                    [
                        'code'       => 'traffic',
                        'value'      => 'Y',
                        'sort_order' => 6,
                    ],
                    [
                        'code'       => 'exhibition_directories',
                        'value'      => 'Y',
                        'sort_order' => 7,
                    ],
                    [
                        'code'       => 'discounts',
                        'value'      => 'Y',
                        'sort_order' => 8,
                    ],
                ],
            ],
            [
                'plan'     => [
                    'name'              => 'option_3',
                    'description'       => '',
                    'type'              => 'seller',
                    'currency_id'       => 47,
                    'price'             => 0,
                    'interval'          => 'year',
                    'interval_count'    => 20,
                    'trial_period_days' => 0,
                    'promo'             => 0,
                    'sort_order'        => 4,
                ],
                'features' => [
                    [
                        'code'       => 'company_logo',
                        'value'      => 'Y',
                        'sort_order' => 1,
                    ],
                    [
                        'code'       => 'company_banners',
                        'value'      => 'Y',
                        'sort_order' => 2,
                    ],
                    [
                        'code'       => 'public_page',
                        'value'      => 'Y',
                        'sort_order' => 3,
                    ],
                    [
                        'code'       => 'products',
                        'value'      => 10000,
                        'sort_order' => 4,
                    ],
                    [
                        'code'       => 'featured',
                        'value'      => 'Y',
                        'sort_order' => 5,
                    ],
                    [
                        'code'       => 'traffic',
                        'value'      => 'Y',
                        'sort_order' => 6,
                    ],
                    [
                        'code'       => 'exhibition_directories',
                        'value'      => 'Y',
                        'sort_order' => 7,
                    ],
                    [
                        'code'       => 'discounts',
                        'value'      => 'Y',
                        'sort_order' => 8,
                    ],
                ],
            ],
            [
                'plan'     => [
                    'name'              => 'regular',
                    'description'       => '',
                    'type'              => 'buyer',
                    'currency_id'       => 47,
                    'price'             => 0,
                    'interval'          => 'year',
                    'interval_count'    => 20,
                    'trial_period_days' => 0,
                    'promo'             => 0,
                    'sort_order'        => 5,
                ],
                'features' => [
                    [
                        'code'       => 'exhibition_directories',
                        'value'      => 'N',
                        'sort_order' => 1,
                    ],
                    [
                        'code'       => 'show_contact',
                        'value'      => 'N',
                        'sort_order' => 2,
                    ],
                ],
            ],
            [
                'plan'     => [
                    'name'              => 'paid',
                    'description'       => '',
                    'type'              => 'buyer',
                    'currency_id'       => 1,
                    'price'             => 1000,
                    'interval'          => 'year',
                    'interval_count'    => 1,
                    'trial_period_days' => 0,
                    'promo'             => 0,
                    'sort_order'        => 6,
                ],
                'features' => [
                    [
                        'code'       => 'exhibition_directories',
                        'value'      => 'Y',
                        'sort_order' => 1,
                    ],
                    [
                        'code'       => 'show_contact',
                        'value'      => 'Y',
                        'sort_order' => 2,
                    ],
                ],
            ],
        ];

        foreach ($plans as $p) {
            $plan     = Plan::create($p['plan']);
            $features = [];

            foreach ($p['features'] as $feature) {
                $features[] = new PlanFeature($feature);
            }

            $plan->features()->saveMany($features);
        }

    }
}
