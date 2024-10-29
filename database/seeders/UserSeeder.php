<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Juan Komersil',
            'dob' => '2000-10-10',
            'email' => 'rafitosch@gmail.com',
            'password' => bcrypt('111111'),
            'email_verified_at' => now(),
            'role_id' => 3,
            'division_id' => 4,
            'avatar' => 'images/avatar-1.jpg',
            'created_at' => now(),
        ]);
    }
}
