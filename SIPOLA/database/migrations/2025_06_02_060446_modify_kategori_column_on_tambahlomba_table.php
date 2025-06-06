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
        DB::statement("ALTER TABLE tambah_lomba MODIFY kategori_lomba ENUM('akademik', 'non-akademik') DEFAULT 'akademik'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE tambah_lomba MODIFY kategori_lomba VARCHAR(255) DEFAULT 'akademik'");
    }
};