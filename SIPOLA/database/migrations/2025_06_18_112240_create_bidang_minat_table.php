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
        Schema::create('bidang_minat', function (Blueprint $table) {
            $table->id();
            $table->string('nama_minat'); // Contoh: IT, Kesehatan, Teknik
            $table->unsignedBigInteger('parent_id')->nullable(); // Buat sub-bidang (relasi ke minat utama)
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('bidang_minat')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bidang_minat');
    }
};
