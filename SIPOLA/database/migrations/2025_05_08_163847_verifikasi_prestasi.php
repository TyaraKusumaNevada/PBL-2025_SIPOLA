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
        Schema::create('verifikasi_prestasi', function (Blueprint $table) {
            $table->id('id_verifikasi');

            $table->unsignedBigInteger('id_prestasi');
            $table->foreign('id_prestasi')->references('id_prestasi')->on('prestasi')->onDelete('cascade');

            $table->enum('verifikator_type', ['admin', 'dosen']);
            $table->unsignedBigInteger('id_verifikator'); // tidak bisa di-foreign karena tergantung type

            $table->enum('status', ['Pending', 'Disetujui', 'Ditolak']);
            $table->text('catatan')->nullable();
            $table->dateTime('tanggal_verifikasi')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verifikasi_prestasi');
    }
};