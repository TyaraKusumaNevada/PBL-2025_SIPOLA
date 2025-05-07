<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class role extends Migration
{
    public function up()
    {
        Schema::create('role', function (Blueprint $table) {
            $table->id('id_role');
            $table->string('role_kode');
            $table->string('role_nama');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('role');
    }
}
