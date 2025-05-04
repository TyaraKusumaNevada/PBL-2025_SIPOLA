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
        Schema::create('level_user', function (Blueprint $table) {
            $table->id('id_level');
            $table->foreignId('id_mahasiswa')->nullable()->constrained('mahasiswa');
            $table->foreignId('id_admin')->nullable()->constrained('admin');
            $table->foreignId('id_dosen')->nullable()->constrained('dospem');
            $table->string('username');
            $table->string('password');
            $table->enum('role', ['mahasiswa', 'dosen', 'admin']);
            $table->unsignedBigInteger('user_id');
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
