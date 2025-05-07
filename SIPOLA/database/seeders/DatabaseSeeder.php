<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
// Import semua seeder yang mau dipanggil
use Database\Seeders\AdminSeeder;
use Database\Seeders\AngkatanSeeder;
use Database\Seeders\DospemSeeder;
use Database\Seeders\MahasiswaSeeder;
use Database\Seeders\PrestasiSeeder;
use Database\Seeders\ProgramStudiSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\TambahLombaSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       // Panggil semua seeder di sini
       $this->call([
        RoleSeeder::class,
        AngkatanSeeder::class,
        AdminSeeder::class,
        DospemSeeder::class,
        TambahLombaSeeder::class,
        ProgramStudiSeeder::class,
        MahasiswaSeeder::class,
        PrestasiSeeder::class,
    ]);
    }
}