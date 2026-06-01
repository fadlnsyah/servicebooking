<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'view dashboard',
            'manage bookings',
            'approve bookings',
            'reject bookings',
            'complete bookings',
            'manage services',
            'manage categories',
            'manage customers',
            'manage providers',
            'view reports',
            'manage settings',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'web');
        }

        $admin = Role::findOrCreate('admin', 'web');
        $customer = Role::findOrCreate('customer', 'web');
        $provider = Role::findOrCreate('provider', 'web');

        $admin->syncPermissions($permissions);

        $provider->syncPermissions([
            'view dashboard',
            'manage bookings',
            'view reports',
        ]);

        $customer->syncPermissions([
            'view dashboard',
        ]);
    }
}
