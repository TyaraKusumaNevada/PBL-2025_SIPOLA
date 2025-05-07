<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class mahasiswa extends Migration
{
    public function up()
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
            $table->foreign('id_prodi')->references('id')->on('program_studi')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('mahasiswa');
    }
}
