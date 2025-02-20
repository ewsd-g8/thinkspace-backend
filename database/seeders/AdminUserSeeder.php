<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminUserSeeder extends Seeder
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
                'name' => 'Super Admin',
                'full_name' => 'John Wick',
                'email' => 'superadmin@idea.com',
                'password' => '123456',
                'mobile' => '09422555544',
                'is_active' => 1,
                'is_anonymous' => 0,
                'department_id' => 1
            ]
        ];

        $role = Role::where('name', 'Superadmin')->first();

        foreach ($users as $user) {
            $data = User::create([
                    'name' => $user['name'],
                    'full_name' => $user['full_name'],
                    'email' => $user['email'],
                    'password' => bcrypt($user['password']),
                    'mobile' => $user['mobile'],
                    'is_active' => $user['is_active'],
                    'is_anonymous' => $user['is_anonymous'],
                    'department_id' => $user['department_id']
                ]);

            $permissions = Permission::pluck('id', 'id')->all();
            $role->syncPermissions($permissions);
            $data->assignRole($role->name);
        }
    }
}
