<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'Super Admin',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'QA Manager',
                'guard_name' => 'qamanager'
            ],
            [
                'name' => 'QA Coordinator',
                'guard_name' => 'qacoordinator'
            ],
            [
                'name' => 'Staff',
                'guard_name' => 'staff'
            ],
        ];

        foreach ($roles as $role) {
            Role::create([
                'name' => $role['name'],
                'guard_name' => $role['guard_name']
            ]);
        }
    }
}
