<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
                // Reset cached roles and permissions
                app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
                // Create Permissions
                Permission::create(['name' => 'create task']);
                Permission::create(['name' => 'edit task']);
                Permission::create(['name' => 'delete task']);
                Permission::create(['name' => 'publish task']);
                Permission::create(['name' => 'read task']);
                // Create Roles and Assign Permissions
                $admin = Role::create(['name' => 'admin']);
                $admin->givePermissionTo(Permission::all());
                $user = Role::create(['name' => 'user']);
                $user->givePermissionTo(['read task']);
    }
}
