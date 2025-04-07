<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Department;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'QA Coordinator',
                'full_name' => 'Alice Johnson',
                'email' => 'qacoordinator@idea.com',
                'password' => '123456',
                'mobile' => '09422555545',
                'is_active' => 1,
                'department_id' => Department::inRandomOrder()->first()->id,
                'role' => 'QAcoordinator'
            ],
            [
                'name' => 'QA Manager',
                'full_name' => 'Jack Black',
                'email' => 'qamanager@idea.com',
                'password' => '123456',
                'mobile' => '09422555546',
                'is_active' => 1,
                'department_id' => Department::inRandomOrder()->first()->id,
                'role' => 'QAmanager'
            ],
            [
                'name' => 'Staff Member',
                'full_name' => 'Mega Mind',
                'email' => 'staff@idea.com',
                'password' => '123456',
                'mobile' => '09422555547',
                'is_active' => 1,
                'department_id' => Department::inRandomOrder()->first()->id,
                'role' => 'Staff'
            ]
        ];

        $role = Role::where('name', 'Superadmin')->first();

        foreach ($users as $user) {
            $role = Role::where('name', $user['role'])->first();
            
            $data = User::create([
                'name' => $user['name'],
                'full_name' => $user['full_name'],
                'email' => $user['email'],
                'password' => bcrypt($user['password']),
                'mobile' => $user['mobile'],
                'is_active' => $user['is_active'],
                'department_id' => $user['department_id']
            ]);
            
            $data->assignRole($role->name);
        }
    }
}
