<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define permissions
        $permissions = [
            'view bank account',  // Employee action
            'create bank account',  // Employee action
            'submit bank change request',  // Employee action
            'view bank change request',    // HR action
            'approve bank change request', // HR action
            'reject bank change request',  // HR action
        ];

        // Create or get permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create Employee role and assign permissions
        $employeeRole = Role::firstOrCreate(['name' => 'Employee']);
        $employeeRole->givePermissionTo([
            'submit bank change request',
            'view bank account',
            'create bank account'
        ]);

        // Create HR role and assign permissions
        $hrRole = Role::firstOrCreate(['name' => 'HR']);
        $hrRole->givePermissionTo([
            'view bank change request',
            'approve bank change request',
            'reject bank change request'
        ]);
    }
}
