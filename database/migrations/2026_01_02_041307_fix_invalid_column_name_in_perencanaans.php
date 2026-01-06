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
        // Langkah 1: Hapus kolom yang salah (jika masih ada)
        Schema::table('perencanaans', function (Blueprint $table) {
            if (Schema::hasColumn('perencanaans', 'program/kegiatan/kro/ro/komponen/subkomp/detil')) {
                $table->dropColumn('program/kegiatan/kro/ro/komponen/subkomp/detil');
            }
        });
                
        // Langkah 2: Tambahkan kolom 'nama' terlebih dahulu
        Schema::table('perencanaans', function (Blueprint $table) {
            $table->string('nama')->nullable()->after('kode');
        });
                
        // Langkah 3: Tambahkan kolom 'detail' setelah 'nama' dipastikan ada
        Schema::table('perencanaans', function (Blueprint $table) {
            $table->string('detail')->nullable()->after('nama');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perencanaans', function (Blueprint $table) {
            $table->dropColumn(['nama', 'detail']);
        });
    }
};
