<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
         DB::statement("ALTER TABLE tambah_lomba MODIFY tingkat_lomba ENUM('politeknik', 'kota', 'provinsi', 'nasional', 'internasional')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE tambah_lomba MODIFY tingkat_lomba ENUM('lokal', 'nasional', 'internasional')");
    }
};