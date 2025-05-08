<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AngkatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('angkatan')->insert([
            [
                'semester' => 'Ganjil',
                'tahun_ajaran' => '2023/2024',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'semester' => 'Genap',
                'tahun_ajaran' => '2023/2024',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'semester' => 'Ganjil',
                'tahun_ajaran' => '2024/2025',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}