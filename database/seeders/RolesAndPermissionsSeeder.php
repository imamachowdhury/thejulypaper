<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        Permission::create(['name' => 'manage articles']);
        Permission::create(['name' => 'publish articles']);
        Permission::create(['name' => 'edit all articles']);
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'manage roles']);
        Permission::create(['name' => 'view dashboard']);

        // Create roles and assign permissions
        $admin = Role::create(['name' => 'Admin']);
        $admin->givePermissionTo(Permission::all());

        $editor = Role::create(['name' => 'Editor']);
        $editor->givePermissionTo([
            'manage articles',
            'publish articles',
            'edit all articles',
            'view dashboard'
        ]);

        $author = Role::create(['name' => 'Author']);
        $author->givePermissionTo([
            'manage articles',
            'view dashboard'
        ]);

        $viewer = Role::create(['name' => 'Viewer']);
        $viewer->givePermissionTo(['view dashboard']);
    }
}
