<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['key' => 'user_view', 'description' => 'View Permission.'],
            ['key' => 'user_edit', 'description' => 'Edit Permission'],
            ['key' => 'user_delete', 'description' => 'Delete Permission'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
