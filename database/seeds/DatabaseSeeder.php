<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ProdukTableSeeder::class);
        $this->call(RoleAndPermissionTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(SettingTableSeeder::class);
    }
}
