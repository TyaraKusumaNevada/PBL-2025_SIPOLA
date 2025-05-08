<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->unsignedBigInteger('id_angkatan')->nullable()->after('id_prodi');

            $table->foreign('id_angkatan')->references('id_angkatan')->on('angkatan')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->dropForeign(['id_angkatan']);
            $table->dropColumn('id_angkatan');
        });
    }
};
