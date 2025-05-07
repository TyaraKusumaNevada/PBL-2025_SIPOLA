<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class dospem extends Migration
{
    public function up()
    {
        Schema::create('dospem', function (Blueprint $table) {
            $table->id('id_dosen');
            $table->unsignedBigInteger('id_role');
            $table->foreign('id_role')->references('id_role')->on('role')->onDelete('cascade');
            $table->string('nama');
            $table->string('nidn')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('bidang_minat')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dosen');
    }
}
