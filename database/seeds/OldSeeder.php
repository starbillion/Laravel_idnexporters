<?php

use App\Plan;
use App\User;
use Illuminate\Database\Seeder;

class OldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->others([
            'bans',
            'contacts',
            'continents',
            'countries',
            'coupons',
            'currencies',
            'endorsements',
            'exhibitors',
            'exhibitions',
            'exhibition_exhibitors',
            'faq_categories',
            'faq_posts',
            'languages',
            'media',
            'messenger_messages',
            'messenger_participants',
            'messenger_threads',
            'news',
            'notifications',
            'pages',
        ]);
        $this->call(PlanSeeder::class);
        $this->call(LaratrustSeeder::class);

        /************** USERS **************/
        $olds = DB::connection('old')
            ->table('users')
            ->where('id', '>', 2)
            ->get();

        foreach ($olds as $old) {
            DB::table('users')->insert((array) $old);
        }

        $this->others([
            'plan_requests',
            'plan_subscriptions',
            'plan_subscription_usages',
            'product_categories',
            'product_posts',
            'product_post_visits',
            'searches',
            'visits',
            'role_user',
        ]);

        $this->finishing();
    }

    public function others($tables)
    {
        foreach ($tables as $table) {
            $this->command->info('------------- ' . strtoupper($table) . ' -------------');

            $olds = DB::connection('old')->table($table);

            if ($table == 'role_user') {
                $olds->whereNotIn('user_id', [1, 2]);
            }

            $olds = $olds->get();

            foreach ($olds as $old) {
                DB::table($table)->insert((array) $old);
            }
        }
    }

    public function finishing()
    {
        $users = User::withAnyStatus()->get();
        $plan  = Plan::where(['name' => 'regular', 'type' => 'buyer'])->first();

        foreach ($users as $user) {
            if ($user->hasRole('buyer')) {
                $user->newSubscription('main', $plan)->create();
            }
        }
    }
}
