<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('mahasiswa')->insert([
            [
                'id_mahasiswa'   => 1,
                'id_role'        => 3, // Role Mahasiswa
                'id_prodi'       => 1, // Sesuaikan dengan id program_studi yang tersedia
                'id_angkatan'    => 1,
                'nama'           => 'Ahmad Fauzi',
                'nim'            => '2141720001',
                'email'          => 'ahmadfauzi@students.polinema.ac.id',
                'password'       => Hash::make('mahasiswa123'),
                'bidang_keahlian'=> 'Jaringan Komputer',
                'minat'          => 'Cybersecurity, Routing',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'id_mahasiswa'   => 2,
                'id_role'        => 3,
                'id_prodi'       => 1,
                'id_angkatan'    => 1,
                'nama'           => 'Rina Kurnia',
                'nim'            => '2141720002',
                'email'          => 'rinakurnia@students.polinema.ac.id',
                'password'       => Hash::make('mahasiswa123'),
                'bidang_keahlian'=> 'Pemrograman Web',
                'minat'          => 'Laravel, Vue.js',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ]);
    }
}
