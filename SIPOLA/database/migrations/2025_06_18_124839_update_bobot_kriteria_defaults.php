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
            $table->float('bobot_biaya')->default(0.15)->change();
            $table->float('bobot_hadiah')->default(0.2)->change();
            $table->float('bobot_tingkat')->default(0.2)->change();
            $table->float('bobot_sisa_hari')->default(0.1)->change();
            $table->float('bobot_format')->default(0.1)->change();
            $table->float('bobot_minat')->default(0.15)->change();
            $table->float('bobot_tipe_lomba')->default(0.1)->change(); // kalau sudah ditambah sebelumnya
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
