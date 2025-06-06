<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE prestasi MODIFY tingkat_prestasi ENUM('politeknik', 'kota', 'nasional', 'internasional')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE prestasi MODIFY tingkat_prestasi ENUM('lokal', 'nasional', 'internasional')");
    }
};