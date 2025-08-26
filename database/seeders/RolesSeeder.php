<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        
        // Create all permissions
        $viewRates = Permission::firstOrCreate([
            'name' => 'view.hourly.rates',
            'guard_name' => 'web',
        ]);
        
        $manageUsers = Permission::firstOrCreate([
            'name' => 'manage users',
            'guard_name' => 'web',
        ]);
        
        $createUsers = Permission::firstOrCreate([
            'name' => 'create users',
            'guard_name' => 'web',
        ]);
        
        $editUsers = Permission::firstOrCreate([
            'name' => 'edit users',
            'guard_name' => 'web',
        ]);
        
        $deleteUsers = Permission::firstOrCreate([
            'name' => 'delete users',
            'guard_name' => 'web',
        ]);
        
        $assignRoles = Permission::firstOrCreate([
            'name' => 'assign roles',
            'guard_name' => 'web',
        ]);

        // Create Roles
        $admin    = Role::firstOrCreate(['name' => 'Admin',    'guard_name' => 'web']);
        $manager  = Role::firstOrCreate(['name' => 'Manager',  'guard_name' => 'web']);
        $employee = Role::firstOrCreate(['name' => 'Employee', 'guard_name' => 'web']);

        // Grant permissions to Admin - gets everything
        $admin->syncPermissions([
            $viewRates,
            $manageUsers,
            $createUsers,
            $editUsers,
            $deleteUsers,
            $assignRoles,
        ]);
        
        // Grant permissions to Manager - limited user management
        $manager->syncPermissions([
            $viewRates,
            // You can add specific permissions here if managers should have limited access
        ]);
        
        // Grant permissions to Employee - basic permissions only
        $employee->syncPermissions([
            // Add any employee-specific permissions here
        ]);
    }
}