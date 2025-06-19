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
        Schema::table('tambah_lomba', function (Blueprint $table) {
            $table->integer('biaya_pendaftaran')->default(0)->after('status_verifikasi');
            $table->integer('hadiah')->default(0)->after('biaya_pendaftaran');
            $table->enum('format_lomba', ['online', 'offline'])->default('online')->after('hadiah');
            $table->enum('tipe_lomba', ['tim', 'individu'])->default('individu')->after('format_lomba');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tambah_lomba', function (Blueprint $table) {
            $table->dropColumn(['biaya_pendaftaran', 'hadiah', 'format_lomba', 'tipe_lomba']);
        });
    }
};