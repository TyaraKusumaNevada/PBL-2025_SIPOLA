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
        Schema::create('bobot_kriteria_mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');

            $table->float('bobot_biaya')->default(0.15);        // Cost
            $table->float('bobot_hadiah')->default(0.2);        // Benefit
            $table->float('bobot_tingkat')->default(0.2);       // Benefit
            $table->float('bobot_sisa_hari')->default(0.15);    // Cost
            $table->float('bobot_format')->default(0.15);       // Match (converted to Benefit)
            $table->float('bobot_minat')->default(0.15);        // Match (converted to Benefit)

            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('mahasiswa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bobot_kriteria_mahasiswa');
    }
};