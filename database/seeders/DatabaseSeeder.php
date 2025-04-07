<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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
            CategoryTableSeeder::class,
            PermissionTableSeeder::class,
            RoleTableSeeder::class,
            RoleHasPermissionTableSeeder::class,
            AdminUserSeeder::class,
            UserTableSeeder::class,
            IdeaTableSeeder::class,
        ]);
    }
}
