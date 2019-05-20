<?php

use App\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'title' => 'About Us',
                'slug'  => 'about',
                'body'  => '<p>Did you know that Indonesia is home to more than 22,169 companies? In 2016 Indonesia exported more than USD 12,578 million worth of goods &amp; services to companies in over 214 countries around the world.</p><p>IDNexporters.com is a platform designed to bring together buyers with Indonesian exporters of goods and services in a wide variety of industries.</p><p>We also provide the following services for buyers who are interested to meet our exporters, visit their factories and market survey.</p>',
            ],
            [
                'title' => 'Terms Of Services',
                'slug'  => 'tos',
                'body'  => '<p>Did you know that Indonesia is home to more than 22,169 companies? In 2016 Indonesia exported more than USD 12,578 million worth of goods &amp; services to companies in over 214 countries around the world.</p><p>IDNexporters.com is a platform designed to bring together buyers with Indonesian exporters of goods and services in a wide variety of industries.</p><p>We also provide the following services for buyers who are interested to meet our exporters, visit their factories and market survey.</p>',
            ],
        ];

        foreach ($data as $d) {
            Page::insert($d);
        }
    }
}
