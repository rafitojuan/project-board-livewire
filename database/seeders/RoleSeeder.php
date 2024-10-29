<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'SM', 'color' => '#6A2C70'],
            ['name' => 'ASM', 'color' => '#B83B5E'],
            ['name' => 'Staff', 'color' => '#F9ED69'],
            ['name' => 'Teknik', 'color' => '#6A2C70'],
            ['name' => 'Superadmin', 'color' => '#605678'],
            ['name' => 'Admin', 'color' => '#01204E'],
            ['name' => 'Guest', 'color' => '#BFECFF'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
