<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $super_admin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'super@admin.com',
        ]);
        $roleSuperAdmin = Role::create(['name' => 'super-admin']);
        $super_admin->assignRole($roleSuperAdmin);

        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
        ]);
        $admin_role = Role::create(['name' => 'admin']);
        $admin->assignRole($admin_role);

        $author_role = Role::create(['name' => 'author']);

        $author1 = User::factory()->create([
            'name' => 'author1',
            'email' => 'author1@btu.com',
        ]);
        $author1->assignRole($author_role);
        $author2 = User::factory()->create([
            'name' => 'author2',
            'email' => 'author2@btu.com',
        ]);
        $author2->assignRole($author_role);

        $author3 = User::factory()->create([
            'name' => 'author3',
            'email' => 'author3@btu.com',
        ]);
        $author3->assignRole($author_role);
        // $permission = Permission::create(['name' => 'edit articles']);
    }
}
