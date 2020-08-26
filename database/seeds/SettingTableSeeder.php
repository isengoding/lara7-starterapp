<?php

use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Setting::create([
            'app_name'  => 'Starter App',
            'logo' => 'logo_default.png',
            'favicon'  => 'favicon_default.ico',
            'footer_right'  => 'Ver 1.0',
            'footer_left'  => 'Starter App Laravel 7 & Admin LTE 3',
        ]);
    }
}
