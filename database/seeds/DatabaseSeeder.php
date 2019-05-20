<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(CountriesTableSeeder::class);
        // $this->call(LanguageSeeder::class);
        // $this->call(CurrencySeeder::class);
        // $this->call(PlanSeeder::class);
        // $this->call(LaratrustSeeder::class);
        // $this->call(CategoriesTableSeeder::class);
        // $this->call(NewsSeeder::class);
        // $this->call(PageSeeder::class);
        // $this->call(FaqSeeder::class);

        $this->call(OldSeeder::class);
    }
}
