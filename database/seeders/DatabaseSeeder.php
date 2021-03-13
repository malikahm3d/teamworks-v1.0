<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        Permission::create(['name' => 'edit roles']);
        Permission::create(['name' => 'remove roles']);
        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'permission to say hellp']);

        $role = Role::create(['name' => 'admin'])->givePermissionTo(['edit roles', 'remove roles', 'create roles']);
    }
}
