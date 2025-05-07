<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class LevelUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_level'=> 1,
                'id_mahasiswa' => null,
                'id_admin' => 1,
                'id_dosen' => null,
                'username' => 'admin_utama',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'user_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_level'=> 2,
                'id_mahasiswa' => null,
                'id_admin' => 2,
                'id_dosen' => null,
                'username' => 'admin_kemahasiswaan',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'user_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];

        // pastikan nama tabel sesuai
        DB::table('level_user')->insert($data);
    }
}
