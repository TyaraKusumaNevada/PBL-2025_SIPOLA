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
        Schema::create('preferensi_mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('bidang_minat')->nullable();
            $table->enum('prefer_format', ['online', 'offline', 'bebas'])->default('bebas');
            $table->enum('prefer_tipe_lomba', ['tim', 'individu', 'bebas'])->default('bebas');
            $table->integer('max_biaya')->default(0);
            $table->integer('min_hadiah')->default(0);
            $table->enum('min_tingkat', ['politeknik', 'kota', 'provinsi', 'nasional', 'internasional'])->default('politeknik');
            $table->integer('min_sisa_hari')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('mahasiswa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preferensi_mahasiswa');
    }
};