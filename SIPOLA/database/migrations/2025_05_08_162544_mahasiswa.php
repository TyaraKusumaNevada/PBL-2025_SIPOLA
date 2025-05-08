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
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->id('id_mahasiswa');
            $table->unsignedBigInteger('id_role');
            $table->foreign('id_role')->references('id_role')->on('role')->onDelete('cascade');
            $table->string('nama');
            $table->string('nim')->unique();
            $table->string('password');
            $table->string('email')->unique();
            $table->string('bidang_keahlian')->nullable();
            $table->text('minat')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('id_prodi');
            $table->foreign('id_prodi')->references('id_prodi')->on('program_studi')->onDelete('cascade');
            
            $table->unsignedBigInteger('id_angkatan')->nullable();
            $table->foreign('id_angkatan')->references('id_angkatan')->on('angkatan')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswa');
    }
};