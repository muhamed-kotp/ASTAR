<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        $arrayOfPermissionNames = [
            'create-users',
            'edit-users',
            'delete-users',
            'view-users',
            'create-items',
            'edit-items',
            'delete-items',
            'view-items',
            'create-categories',
            'edit-categories',
            'delete-categories',
            'view-categories',
            'create-partitions',
            'edit-partitions',
            'delete-partitions',
            'view-partitions',
            'edit-orders',
            'delete-orders',
            'view-orders',
            'create-settings',
            'edit-settings',
            'delete-settings',
            'view-settings',
        ];

        $permissions = collect($arrayOfPermissionNames)->map(function($permission){
            return ['name' => $permission, 'guard_name' => 'web'];
        });
        Permission::insert($permissions->toArray());

        $role = Role::create(['name' => 'super admin'])->givePermissionTo($arrayOfPermissionNames);
    }
}
