<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramStudiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('program_studi')->insert([
            [
                'id'   => 1,
                'nama_prodi' => 'Teknologi Informasi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id'   => 2,
                'nama_prodi' => 'Sistem Informasi Bisnis',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
