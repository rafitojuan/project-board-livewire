<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $division = [
            [
                'id' => 1,
                'jabatan' => 'Direktur Komersial dan Operasi',
                'divisi' => 'null',
                'status' => 1
            ],
            [
                'id' => 2,
                'jabatan' => 'SM Komersial',
                'divisi' => 'Komersial',
                'status' => 1
            ],
            [
                'id' => 3,
                'jabatan' => 'ASM Pelayanan Pelanggan dan Pengembangan Bisnis',
                'divisi' => 'Komersial',
                'status' => 1
            ],
            [
                'id' => 4,
                'jabatan' => 'ASM Manajemen Data dan IT',
                'divisi' => 'Komersial',
                'status' => 1
            ],
            [
                'id' => 5,
                'jabatan' => 'SM Teknik dan Operasi',
                'divisi' => 'Teknik dan Operasi',
                'status' => 1
            ],
            [
                'id' => 6,
                'jabatan' => 'ASM Operasi',
                'divisi' => 'Teknik dan Operasi',
                'status' => 1
            ],
            [
                'id' => 7,
                'jabatan' => 'ASM Teknik',
                'divisi' => 'Teknik dan Operasi',
                'status' => 1
            ],
            [
                'id' => 8,
                'jabatan' => 'Staff Pelayanan Pelanggan dan Pengembangan Bisnis',
                'divisi' => 'Komersial',
                'status' => 1
            ],
            [
                'id' => 9,
                'jabatan' => 'Staff Manajemen Data dan IT',
                'divisi' => 'Komersial',
                'status' => 1
            ],
            [
                'id' => 10,
                'jabatan' => 'Staff Operasi',
                'divisi' => 'Teknik dan Operasi',
                'status' => 1
            ],
            [
                'id' => 11,
                'jabatan' => 'Staff Teknik',
                'divisi' => 'Teknik dan Operasi',
                'status' => 1
            ]
        ];

        DB::table('divisions')->insert($division);
    }
}
