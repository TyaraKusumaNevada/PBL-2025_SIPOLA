<?php

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
        Schema::table('bobot_kriteria_mahasiswa', function (Blueprint $table) {
            $table->float('bobot_tipe_lomba')->default(0.1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bobot_kriteria_mahasiswa', function (Blueprint $table) {
            $table->dropColumn('bobot_tipe_lomba');
        });
    }
};