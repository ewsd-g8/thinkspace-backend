<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Department::factory()->count(5)->create();

        $this->call([
            DepartmentTableSeeder::class,
            PermissionTableSeeder::class,
            RoleTableSeeder::class,
            AdminUserSeeder::class,
        ]);
    }
}
