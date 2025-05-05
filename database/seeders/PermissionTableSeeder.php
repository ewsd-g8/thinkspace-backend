<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            [
                'category' => 'User Management',
                'name' => 'user-list',
                'label' => 'Read',
                'guard_name' => 'admin'
            ],
            [
                'category' => 'User Management',
                'name' => 'user-create',
                'label' => 'Write',
                'guard_name' => 'admin'
            ],
            [
                'category' => 'User Management',
                'name' => 'user-edit',
                'label' => 'Update',
                'guard_name' => 'admin'
            ],
            [
                'category' => 'User Management',
                'name' => 'user-delete',
                'label' => 'Destroy',
                'guard_name' => 'admin'
            ],
            [
                'category' => 'Role Management',
                'name' => 'role-list',
                'label' => 'Read',
                'guard_name' => 'admin'
            ],
            [
                'category' => 'Role Management',
                'name' => 'role-create',
                'label' => 'Write',
                'guard_name' => 'admin'
            ],
            [
                'category' => 'Role Management',
                'name' => 'role-edit',
                'label' => 'Update',
                'guard_name' => 'admin'
            ],
            [
                'category' => 'Role Management',
                'name' => 'role-delete',
                'label' => 'Destroy',
                'guard_name' => 'admin'
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'category' => $permission['category'],
                'name' => $permission['name'],
                'label' => $permission['label'],
                'guard_name' => $permission['guard_name']
            ]);
        }
    }
}
