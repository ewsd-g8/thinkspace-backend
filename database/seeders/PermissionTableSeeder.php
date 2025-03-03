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
            [
                'category' => 'Category Management',
                'name' => 'category-list',
                'label' => 'Read',
                'guard_name' => 'admin'
            ],
            [
                'category' => 'Category Management',
                'name' => 'category-create',
                'label' => 'Write',
                'guard_name' => 'admin'
            ],
            [
                'category' => 'Category Management',
                'name' => 'category-edit',
                'label' => 'Update',
                'guard_name' => 'admin'
            ],
            [
                'category' => 'Category Management',
                'name' => 'category-delete',
                'label' => 'Destroy',
                'guard_name' => 'admin'
            ],
            [
                'category' => 'Closure Management',
                'name' => 'closure-list',
                'label' => 'Read',
                'guard_name' => 'admin'
            ],
            [
                'category' => 'Closure Management',
                'name' => 'closure-create',
                'label' => 'Write',
                'guard_name' => 'admin'
            ],
            [
                'category' => 'Closure Management',
                'name' => 'closure-edit',
                'label' => 'Update',
                'guard_name' => 'admin'
            ],
            [
                'category' => 'Closure Management',
                'name' => 'closure-delete',
                'label' => 'Destroy',
                'guard_name' => 'admin'
            ],
            [
                'category' => 'Idea Management',
                'name' => 'idea-list',
                'label' => 'Read',
                'guard_name' => 'admin'
            ],
            [
                'category' => 'Idea Management',
                'name' => 'idea-create',
                'label' => 'Write',
                'guard_name' => 'admin'
            ],
            [
                'category' => 'Idea Management',
                'name' => 'idea-edit',
                'label' => 'Update',
                'guard_name' => 'admin'
            ],
            [
                'category' => 'Idea Management',
                'name' => 'idea-delete',
                'label' => 'Destroy',
                'guard_name' => 'admin'
            ],
            [
                'category' => 'Department Management',
                'name' => 'department-list',
                'label' => 'Read',
                'guard_name' => 'admin'
            ],
            [
                'category' => 'Department Management',
                'name' => 'department-create',
                'label' => 'Write',
                'guard_name' => 'admin'
            ],
            [
                'category' => 'Department Management',
                'name' => 'department-edit',
                'label' => 'Update',
                'guard_name' => 'admin'
            ],
            [
                'category' => 'Department Management',
                'name' => 'department-delete',
                'label' => 'Destroy',
                'guard_name' => 'admin'
            ],
            [
                'category' => 'Comment Management',
                'name' => 'comment-list',
                'label' => 'Read',
                'guard_name' => 'admin'
            ],
            [
                'category' => 'Comment Management',
                'name' => 'comment-create',
                'label' => 'Write',
                'guard_name' => 'admin'
            ],
            [
                'category' => 'Comment Management',
                'name' => 'comment-edit',
                'label' => 'Update',
                'guard_name' => 'admin'
            ],
            [
                'category' => 'Comment Management',
                'name' => 'comment-delete',
                'label' => 'Destroy',
                'guard_name' => 'admin'
            ],
            [
                'category' => 'Reaction Management',
                'name' => 'reaction-list',
                'label' => 'Read',
                'guard_name' => 'admin'
            ],
            [
                'category' => 'Reaction Management',
                'name' => 'reaction-create',
                'label' => 'Write',
                'guard_name' => 'admin'
            ],
            [
                'category' => 'View Management',
                'name' => 'view-list',
                'label' => 'Read',
                'guard_name' => 'admin'
            ],
            [
                'category' => 'View Management',
                'name' => 'view-create',
                'label' => 'Write',
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
