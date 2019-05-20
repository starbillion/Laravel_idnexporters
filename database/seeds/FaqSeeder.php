<?php

use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'Registration & Membership' => [
                [
                    'question' => 'How to Register?',
                    'answer'   => 'You can register a new account <a href="' . route('register') . '">here</a>.',
                ],
                [
                    'question' => 'I have registered, but why my public profile and products are not showing?',
                    'answer'   => 'It takes approximately 2 x 24 hours for us to review your account. After review, we might approve your account. Only after being approved, your company profile and products will show to the public.',
                ],
            ],
            'Products'                  => [
                [
                    'question' => 'How to post products?',
                    'answer'   => 'After you have created an account, you may post your products in your "My Dashboard" section. Your posts will be put under review before being published to the website. You will be notified via email if your account or products has been published.',
                ],
            ],
        ];

        foreach ($data as $category => $posts) {
            $c = DB::table('faq_categories')->insertGetId(['name' => $category]);

            foreach ($posts as $post) {
                DB::table('faq_posts')->insert(array_merge($post, ['category_id' => $c]));
            }
        }
    }
}
