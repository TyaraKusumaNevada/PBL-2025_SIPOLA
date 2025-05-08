<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admin')->insert([
            [
                'id_admin'   => 1,
                'id_role'    => 1,
                'nama'       => 'Admin Utama',
                'email'      => 'admin1@polinema.ac.id',
                'password'   => Hash::make('admin123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_admin'   => 2,
                'id_role'    => 1,
                'nama'       => 'Admin Kemahasiswaan',
                'email'      => 'admin2@polinema.ac.id',
                'password'   => Hash::make('admin123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_admin'   => 3,
                'id_role'    => 1,
                'nama'       => 'Admin Prestasi',
                'email'      => 'admin3@polinema.ac.id',
                'password'   => Hash::make('admin123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}