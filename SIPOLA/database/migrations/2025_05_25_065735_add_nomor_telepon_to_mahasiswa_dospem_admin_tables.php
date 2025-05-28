<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNomorTeleponToMahasiswaDospemAdminTables extends Migration
{
    public function up()
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->string('nomor_telepon')->nullable()->after('email'); 
        });

        Schema::table('dospem', function (Blueprint $table) {
            $table->string('nomor_telepon')->nullable()->after('email'); 
        });

        Schema::table('admin', function (Blueprint $table) {
            $table->string('nomor_telepon')->nullable()->after('email'); 
        });
    }

    public function down()
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->dropColumn('nomor_telepon');
        });

        Schema::table('dospem', function (Blueprint $table) {
            $table->dropColumn('nomor_telepon');
        });

        Schema::table('admin', function (Blueprint $table) {
            $table->dropColumn('nomor_telepon');
        });
    }
}
