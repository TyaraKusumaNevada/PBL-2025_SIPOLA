<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('role')->insert([
            [
                'id_role'   => 1,
                'role_kode' => 'ADM',
                'role_nama' => 'Admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_role'   => 2,
                'role_kode' => 'DSN',
                'role_nama' => 'Dosen',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_role'   => 3,
                'role_kode' => 'MHS',
                'role_nama' => 'Mahasiswa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}