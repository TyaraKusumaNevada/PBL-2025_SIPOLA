<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TambahLombaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tambah_lomba')->insert([
            [
                'nama_lomba' => 'Lomba Inovasi Teknologi 2024',
                'kategori_lomba' => 'Teknologi',
                'tingkat_lomba' => 'nasional',
                'penyelenggara_lomba' => 'Kementerian Riset dan Teknologi',
                'deskripsi' => 'Kompetisi pengembangan teknologi inovatif untuk mahasiswa seluruh Indonesia.',
                'tanggal_mulai' => '2024-09-01',
                'tanggal_selesai' => '2024-10-01',
                'pamflet_lomba' => 'inovasi_tekno_2024.jpg',
                'status_verifikasi' => 'Disetujui',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_lomba' => 'Web Development Challenge 2024',
                'kategori_lomba' => 'Pemrograman',
                'tingkat_lomba' => 'lokal',
                'penyelenggara_lomba' => 'Jurusan TI Polinema',
                'deskripsi' => 'Kompetisi membuat aplikasi berbasis web bagi mahasiswa Polinema.',
                'tanggal_mulai' => '2024-07-10',
                'tanggal_selesai' => '2024-07-20',
                'pamflet_lomba' => 'web_dev_challenge.jpg',
                'status_verifikasi' => 'Pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
