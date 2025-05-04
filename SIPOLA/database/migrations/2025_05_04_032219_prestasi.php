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
        Schema::create('prestasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_mahasiswa')->constrained('mahasiswa');
            $table->string('nama_prestasi');
            $table->enum('kategori_prestasi', ['akademik', 'non-akademik']);
            $table->enum('tingkat_prestasi', ['lokal', 'nasional', 'internasional']);
            $table->string('penyelenggara')->nullable();
            $table->dateTime('tanggal');
            $table->string('bukti_file');
            $table->string('status')->default('Pending');
            $table->timestamps();
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
