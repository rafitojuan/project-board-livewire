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
            ['name' => 'Komersial', 'color' => '#F9ED69'],
            ['name' => 'Teknik', 'color' => '#6A2C70'],
            ['name' => 'Guest', 'color' => '#BFECFF'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
