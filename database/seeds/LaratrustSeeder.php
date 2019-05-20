<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Gerardojbaez\LaraPlans\Models\Plan;

class LaratrustSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        $this->truncateLaratrustTables();

        $config         = config('laratrust_seeder.role_structure');
        $userPermission = config('laratrust_seeder.permission_structure');
        $mapPermission  = collect(config('laratrust_seeder.permissions_map'));
        $domain         = preg_replace('(^https?://)', '', config('app.url'));

        foreach ($config as $key => $modules) {
            // Create a new role
            $role = \App\Role::create([
                'name'         => $key,
                'display_name' => ucwords(str_replace('_', ' ', $key)),
                'description'  => ucwords(str_replace('_', ' ', $key)),
            ]);

            $this->command->info('------------- ' . strtoupper($key) . ' -------------');

            // Reading role permission modules
            foreach ($modules as $module => $value) {
                $permissions = explode(',', $value);

                foreach ($permissions as $p => $perm) {
                    $permissionValue = $mapPermission->get($perm);

                    $permission = \App\Permission::firstOrCreate([
                        'name'         => $permissionValue . '-' . $module,
                        'display_name' => ucfirst($permissionValue) . ' ' . ucfirst($module),
                        'description'  => ucfirst($permissionValue) . ' ' . ucfirst($module),
                    ]);

                    if (!$role->hasPermission($permission->name)) {
                        $role->attachPermission($permission);
                    } else {
                        $this->command->info($key . ': ' . $p . ' ' . $permissionValue . ' already exist');
                    }
                }
            }

            $this->command->info('Email    : ' . $key . '@' . $domain);
            $this->command->info('Password : password');

            if ($key == 'seller') {
                $sellers = [
                    // 'regular',
                    // 'option_1',
                    // 'option_2',
                    // 'option_3',
                ];

                foreach ($sellers as $seller) {
                    $plan           = Plan::where(['name' => $seller, 'type' => 'seller'])->first();
                    $user           = new \App\User;
                    $user->verified = true;
                    $user->fill([
                        'name'       => ucwords(str_replace('_', ' ', $seller)),
                        'company'    => 'Company ' . ucwords(str_replace('_', ' ', $seller)),
                        'email'      => 'seller_' . strtolower($seller) . '@' . $domain,
                        'address'    => 'Cendana #666',
                        'city'       => 'Jakarta',
                        'country_id' => 101,
                        'password'   => 'password',
                        // 'main_exports' => 'Coffee, Tea',
                    ]);

                    if ($seller == 'option_2') {
                        $user->balance = 1000000;
                    }

                    $user->save();
                    $user->markApproved();
                    $user->attachRole($role);
                    $user->newSubscription('main', $plan)->create();
                }

            } elseif ($key == 'buyer') {
                $buyers = [
                    // 'regular',
                    // 'paid',
                ];

                foreach ($buyers as $buyer) {
                    $plan           = Plan::where(['name' => $buyer, 'type' => 'buyer'])->first();
                    $user           = new \App\User;
                    $user->verified = true;
                    $user->fill([
                        'name'       => ucwords(str_replace('_', ' ', $buyer)),
                        'company'    => 'Company ' . ucwords(str_replace('_', ' ', $buyer)),
                        'email'      => 'buyer_' . strtolower($buyer) . '@' . $domain,
                        'address'    => 'Cendana #666',
                        'city'       => 'Jakarta',
                        'country_id' => 101,
                        'password'   => 'password',
                        // 'main_exports' => 'Coffee, Tea',
                    ]);

                    $user->save();
                    $user->markApproved();
                    $user->attachRole($role);
                    $user->newSubscription('main', $plan)->create();
                }
            } else {
                $user           = new \App\User;
                $user->verified = true;
                $user->fill([
                    'name'     => ucwords(str_replace('_', ' ', $key)),
                    'email'    => $key . '@' . $domain,
                    'password' => 'password',
                ]);
                $user->save();
                $user->markApproved();
                $user->attachRole($role);
            }
        }

        // creating user with permissions
        if (!empty($userPermission)) {
            foreach ($userPermission as $key => $modules) {
                foreach ($modules as $module => $value) {
                    $permissions = explode(',', $value);
                    // Create default user for each permission set
                    $user = \App\User::create([
                        'name'           => ucwords(str_replace('_', ' ', $key)),
                        'email'          => $key . '@' . $domain,
                        'password'       => 'password',
                        'remember_token' => str_random(10),
                    ]);
                    foreach ($permissions as $p => $perm) {
                        $permissionValue = $mapPermission->get($perm);

                        $permission = \App\Permission::firstOrCreate([
                            'name'         => $permissionValue . '-' . $module,
                            'display_name' => ucfirst($permissionValue) . ' ' . ucfirst($module),
                            'description'  => ucfirst($permissionValue) . ' ' . ucfirst($module),
                        ]);

                        $this->command->info('Creating Permission to ' . $permissionValue . ' for ' . $module);

                        if (!$user->hasPermission($permission->name)) {
                            $user->attachPermission($permission);
                        } else {
                            $this->command->info($key . ': ' . $p . ' ' . $permissionValue . ' already exist');
                        }
                    }
                }
            }
        }
    }

    /**
     * Truncates all the laratrust tables and the users table
     * @return    void
     */
    public function truncateLaratrustTables()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('permission_role')->truncate();
        DB::table('permission_user')->truncate();
        DB::table('role_user')->truncate();
        \App\User::truncate();
        \App\Role::truncate();
        \App\Permission::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
