<?php

namespace Database\Seeders;

use App\Models\Column;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ColumnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $columns = [
            [
                'name' => 'Upcoming',
            ],
            [
                'name' => 'In Progress',
            ],
            [
                'name' => 'Completed',
            ],
        ];

        foreach ($columns as $column) {
            Column::create($column);
        }
    }
}
