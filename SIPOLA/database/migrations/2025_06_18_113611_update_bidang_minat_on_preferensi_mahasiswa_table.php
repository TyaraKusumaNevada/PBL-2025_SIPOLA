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
         // Hapus kolom lama 'bidang_minat' jika ada
        if (Schema::hasColumn('preferensi_mahasiswa', 'bidang_minat')) {
            Schema::table('preferensi_mahasiswa', function (Blueprint $table) {
                $table->dropColumn('bidang_minat');
            });
        }

            // Tambahkan kolom baru bidang_minat_id dan relasinya
        Schema::table('preferensi_mahasiswa', function (Blueprint $table) {
            $table->unsignedBigInteger('bidang_minat_id')->nullable()->after('user_id');
            $table->foreign('bidang_minat_id')->references('id')->on('bidang_minat')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('preferensi_mahasiswa', function (Blueprint $table) {
            $table->dropForeign(['bidang_minat_id']);
            $table->dropColumn('bidang_minat_id');
        });
    }
};