<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DospemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('dospem')->insert([
            'id_dosen'     => 1,
            'id_role'      => 2, // Sesuai dengan role "dosen"
            'nama'         => 'Dr. Andi Wijaya',
            'nidn'         => '1234567890',
            'email'        => 'andi.wijaya@polinema.ac.id',
            'password'     => Hash::make('password123'),
            'bidang_minat' => 'Jaringan Komputer',
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);
    }
}
