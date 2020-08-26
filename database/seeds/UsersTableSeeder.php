<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\User::create([
            'name'  => 'Isengoding',
            'email' => 'admin@admin.com',
            'password'  => bcrypt('password'),
            'status'  => true,
        ]);
        $user = $user->assignRole('admin');

        $user = \App\User::create([
            'name'  => 'Tomiko Van',
            'email' => 'user1@example.com',
            'password'  => bcrypt('password'),
            'status'  => true,
        ]);
        $user = $user->assignRole('kasir');

        $user = \App\User::create([
            'name'  => 'Elder Titan',
            'email' => 'user2@example.com',
            'password'  => bcrypt('password'),
            'status'  => true,
        ]);
        $user = $user->assignRole('kasir');
    }
}
