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
                'name' => 'Superadmin',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'QAmanager',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'QAcoordinator',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'Staff',
                'guard_name' => 'admin'
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
