<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BidangMinatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bidang_minat')->insert([
            // Akademik
            ['nama_minat' => 'Pengembangan Web'],
            ['nama_minat' => 'Pemrograman Mobile'],
            ['nama_minat' => 'UI/UX Design'],
            ['nama_minat' => 'Data Science & AI'],
            ['nama_minat' => 'Keamanan Siber'],
            ['nama_minat' => 'Jaringan Komputer'],
            ['nama_minat' => 'Game Development'],

            // Non-akademik
            ['nama_minat' => 'Kepemimpinan dan Organisasi'],
            ['nama_minat' => 'Kewirausahaan (Startup / Bisnis)'],
            ['nama_minat' => 'Public Speaking & Debat'],
            ['nama_minat' => 'Desain Grafis & Multimedia'],
            ['nama_minat' => 'Videografi & Konten Kreatif'],
            ['nama_minat' => 'Olahraga & Kesehatan'],
            ['nama_minat' => 'Seni & Budaya'],
        ]);
    }
}