<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'manajemen users', 'guard_name' => 'web']);
        Permission::create(['name' => 'manajemen roles', 'guard_name' => 'web']);
        Permission::create(['name' => 'manajemen produk', 'guard_name' => 'web']);
        Permission::create(['name' => 'manajemen kategori', 'guard_name' => 'web']);

        
        $role = Role::create(['name' => 'admin', 'guard_name' => 'web'])
            ->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'kasir', 'guard_name' => 'web'])
            ->givePermissionTo(['manajemen produk', 'manajemen kategori']);
    }
}
