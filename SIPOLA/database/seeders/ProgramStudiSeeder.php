<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramStudiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('program_studi')->insert([
            [
                'id_prodi'   => 3,
                'nama_prodi' => 'Teknologi Informasi',
                'jenjang'    => 'D4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_prodi'   => 4,
                'nama_prodi' => 'Sistem Informasi Bisnis',
                'jenjang'    => 'D4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}