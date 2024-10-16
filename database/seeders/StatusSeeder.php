<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            [
                'name' => 'ready',
                'color' => '#34C759',
            ],
            [
                'name' => 'waiting',
                'color' => '#FFC107',
            ],
            [
                'name' => 'pending',
                'color' => '#FF9800',
            ],
            [
                'name' => 'approved by asm',
                'color' => '#8BC34A',
            ],
            [
                'name' => 'approved by sm',
                'color' => '#4CAF50',
            ],
            [
                'name' => 'completed',
                'color' => '#009688',
            ],
        ];

        foreach ($statuses as $status) {
            Status::create($status);
        }
    }
}
