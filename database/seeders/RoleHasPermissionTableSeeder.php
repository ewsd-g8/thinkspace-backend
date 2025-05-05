<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleHasPermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleHasPermissions = [
            //Staff
            [
                'permission' => Permission::where('name', "category-list")->first(),
                'role' => Role::where('name', 'Staff')->first()
            ],
            [
                'permission' => Permission::where('name', "closure-list")->first(),
                'role' => Role::where('name', 'Staff')->first()
            ],
            [
                'permission' => Permission::where('name', "comment-list")->first(),
                'role' => Role::where('name', 'Staff')->first()
            ],
            [
                'permission' => Permission::where('name', "comment-create")->first(),
                'role' => Role::where('name', 'Staff')->first()
            ],
            [
                'permission' => Permission::where('name', "department-list")->first(),
                'role' => Role::where('name', 'Staff')->first()
            ],
            [
                'permission' => Permission::where('name', "idea-list")->first(),
                'role' => Role::where('name', 'Staff')->first()
            ],
            [
                'permission' => Permission::where('name', "idea-create")->first(),
                'role' => Role::where('name', 'Staff')->first()
            ],
            [
                'permission' => Permission::where('name', "idea-edit")->first(),
                'role' => Role::where('name', 'Staff')->first()
            ],
            [
                'permission' => Permission::where('name', "reaction-list")->first(),
                'role' => Role::where('name', 'Staff')->first()
            ],
            [
                'permission' => Permission::where('name', "reaction-create")->first(),
                'role' => Role::where('name', 'Staff')->first()
            ],
            [
                'permission' => Permission::where('name', "report-create")->first(),
                'role' => Role::where('name', 'Staff')->first()
            ],
            [
                'permission' => Permission::where('name', "reportType-list")->first(),
                'role' => Role::where('name', 'Staff')->first()
            ],
            [
                'permission' => Permission::where('name', "view-list")->first(),
                'role' => Role::where('name', 'Staff')->first()
            ],
            [
                'permission' => Permission::where('name', "view-create")->first(),
                'role' => Role::where('name', 'Staff')->first()
            ],

            //QAcoordinator
            [
                'permission' => Permission::where('name', "dashboard-view")->first(),
                'role' => Role::where('name', 'QAcoordinator')->first()
            ],
            [
                'permission' => Permission::where('name', "category-list")->first(),
                'role' => Role::where('name', 'QAcoordinator')->first()
            ],
            [
                'permission' => Permission::where('name', "closure-list")->first(),
                'role' => Role::where('name', 'QAcoordinator')->first()
            ],
            [
                'permission' => Permission::where('name', "comment-list")->first(),
                'role' => Role::where('name', 'QAcoordinator')->first()
            ],
            [
                'permission' => Permission::where('name', "comment-create")->first(),
                'role' => Role::where('name', 'QAcoordinator')->first()
            ],
            [
                'permission' => Permission::where('name', "comment-edit")->first(),
                'role' => Role::where('name', 'QAcoordinator')->first()
            ],
            [
                'permission' => Permission::where('name', "comment-delete")->first(),
                'role' => Role::where('name', 'QAcoordinator')->first()
            ],
            [
                'permission' => Permission::where('name', "department-list")->first(),
                'role' => Role::where('name', 'QAcoordinator')->first()
            ],
            [
                'permission' => Permission::where('name', "idea-list")->first(),
                'role' => Role::where('name', 'QAcoordinator')->first()
            ],
            [
                'permission' => Permission::where('name', "idea-create")->first(),
                'role' => Role::where('name', 'QAcoordinator')->first()
            ],
            [
                'permission' => Permission::where('name', "idea-edit")->first(),
                'role' => Role::where('name', 'QAcoordinator')->first()
            ],
            [
                'permission' => Permission::where('name', "idea-delete")->first(),
                'role' => Role::where('name', 'QAcoordinator')->first()
            ],
            [
                'permission' => Permission::where('name', "reaction-list")->first(),
                'role' => Role::where('name', 'QAcoordinator')->first()
            ],
            [
                'permission' => Permission::where('name', "reaction-create")->first(),
                'role' => Role::where('name', 'QAcoordinator')->first()
            ],
            [
                'permission' => Permission::where('name', "report-create")->first(),
                'role' => Role::where('name', 'QAcoordinator')->first()
            ],
            [
                'permission' => Permission::where('name', "report-edit")->first(),
                'role' => Role::where('name', 'QAcoordinator')->first()
            ],
            [
                'permission' => Permission::where('name', "report-delete")->first(),
                'role' => Role::where('name', 'QAcoordinator')->first()
            ],
            [
                'permission' => Permission::where('name', "reportType-list")->first(),
                'role' => Role::where('name', 'QAcoordinator')->first()
            ],
            [
                'permission' => Permission::where('name', "view-list")->first(),
                'role' => Role::where('name', 'QAcoordinator')->first()
            ],
            [
                'permission' => Permission::where('name', "view-create")->first(),
                'role' => Role::where('name', 'QAcoordinator')->first()
            ],
            [
                'permission' => Permission::where('name', "view-delete")->first(),
                'role' => Role::where('name', 'QAcoordinator')->first()
            ],

            //QAmanager
            [
                'permission' => Permission::where('name', "dashboard-view")->first(),
                'role' => Role::where('name', 'QAmanager')->first()
            ],
            [
                'permission' => Permission::where('name', "category-list")->first(),
                'role' => Role::where('name', 'QAmanager')->first()
            ],
            [
                'permission' => Permission::where('name', "category-create")->first(),
                'role' => Role::where('name', 'QAmanager')->first()
            ],
            [
                'permission' => Permission::where('name', "category-edit")->first(),
                'role' => Role::where('name', 'QAmanager')->first()
            ],
            [
                'permission' => Permission::where('name', "category-delete")->first(),
                'role' => Role::where('name', 'QAmanager')->first()
            ],
            [
                'permission' => Permission::where('name', "closure-list")->first(),
                'role' => Role::where('name', 'QAmanager')->first()
            ],
            [
                'permission' => Permission::where('name', "comment-list")->first(),
                'role' => Role::where('name', 'QAmanager')->first()
            ],
            [
                'permission' => Permission::where('name', "comment-create")->first(),
                'role' => Role::where('name', 'QAmanager')->first()
            ],
            [
                'permission' => Permission::where('name', "comment-edit")->first(),
                'role' => Role::where('name', 'QAmanager')->first()
            ],
            [
                'permission' => Permission::where('name', "comment-delete")->first(),
                'role' => Role::where('name', 'QAmanager')->first()
            ],
            [
                'permission' => Permission::where('name', "department-list")->first(),
                'role' => Role::where('name', 'QAmanager')->first()
            ],
            [
                'permission' => Permission::where('name', "idea-list")->first(),
                'role' => Role::where('name', 'QAmanager')->first()
            ],
            [
                'permission' => Permission::where('name', "idea-create")->first(),
                'role' => Role::where('name', 'QAmanager')->first()
            ],
            [
                'permission' => Permission::where('name', "idea-edit")->first(),
                'role' => Role::where('name', 'QAmanager')->first()
            ],
            [
                'permission' => Permission::where('name', "idea-delete")->first(),
                'role' => Role::where('name', 'QAmanager')->first()
            ],
            [
                'permission' => Permission::where('name', "reaction-list")->first(),
                'role' => Role::where('name', 'QAmanager')->first()
            ],
            [
                'permission' => Permission::where('name', "reaction-create")->first(),
                'role' => Role::where('name', 'QAmanager')->first()
            ],
            [
                'permission' => Permission::where('name', "report-list")->first(),
                'role' => Role::where('name', 'QAmanager')->first()
            ],
            [
                'permission' => Permission::where('name', "report-create")->first(),
                'role' => Role::where('name', 'QAmanager')->first()
            ],
            [
                'permission' => Permission::where('name', "report-edit")->first(),
                'role' => Role::where('name', 'QAmanager')->first()
            ],
            [
                'permission' => Permission::where('name', "report-delete")->first(),
                'role' => Role::where('name', 'QAmanager')->first()
            ],
            [
                'permission' => Permission::where('name', "reportType-list")->first(),
                'role' => Role::where('name', 'QAmanager')->first()
            ],
            [
                'permission' => Permission::where('name', "role-list")->first(),
                'role' => Role::where('name', 'QAmanager')->first()
            ],
            [
                'permission' => Permission::where('name', "user-list")->first(),
                'role' => Role::where('name', 'QAmanager')->first()
            ],
            [
                'permission' => Permission::where('name', "view-list")->first(),
                'role' => Role::where('name', 'QAmanager')->first()
            ],
            [
                'permission' => Permission::where('name', "view-create")->first(),
                'role' => Role::where('name', 'QAmanager')->first()
            ],
            [
                'permission' => Permission::where('name', "view-edit")->first(),
                'role' => Role::where('name', 'QAmanager')->first()
            ],
            [
                'permission' => Permission::where('name', "view-delete")->first(),
                'role' => Role::where('name', 'QAmanager')->first()
            ],
        ];

        foreach ($roleHasPermissions as $roleHasPermission) {
            $roleHasPermission['role']->givePermissionTo($roleHasPermission['permission']);
        }
    }
}
