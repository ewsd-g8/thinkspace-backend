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
                'email' => 'superadmin@idea.com',
                'password' => '123456',
                'mobile' => '09422555544',
                'is_active' => 1
            ]
        ];

        $role = Role::where('name', 'Superadmin')->first();

        foreach ($users as $user) {
            $data = User::create([
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'password' => bcrypt($user['password']),
                    'mobile' => $user['mobile'],
                    'is_active' => $user['is_active']
                ]);

            $permissions = Permission::pluck('id', 'id')->all();
            $role->syncPermissions($permissions);
            $data->assignRole($role->name);
        }
    }
}
