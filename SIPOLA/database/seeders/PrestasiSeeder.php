<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrestasiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('prestasi')->insert([
            [
                'id_mahasiswa' => 1,
                'nama_prestasi' => 'Juara 1 Lomba CTF Cyber Security',
                'kategori_prestasi' => 'non-akademik',
                'tingkat_prestasi' => 'nasional',
                'penyelenggara' => 'Kemenkominfo',
                'tanggal' => '2024-10-15 10:00:00',
                'bukti_file' => 'bukti_ctf_juara1.pdf',
                'status' => 'Pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_mahasiswa' => 2,
                'nama_prestasi' => 'Finalis Olimpiade Matematika Mahasiswa',
                'kategori_prestasi' => 'akademik',
                'tingkat_prestasi' => 'lokal',
                'penyelenggara' => 'Polinema',
                'tanggal' => '2024-09-10 09:00:00',
                'bukti_file' => 'bukti_olim_math.pdf',
                'status' => 'Pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
