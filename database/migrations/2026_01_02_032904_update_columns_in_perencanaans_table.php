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
        Schema::table('perencanaans', function (Blueprint $table) {
            // 1. Hapus Foreign Key Constraint terlebih dahulu
            $table->dropForeign(['status_id']);
            
            // 2. Menghapus kolom yang salah
            $table->dropColumn(['komponen', 'uraian_komponen', 'sub_komponen', 'uraian_sub_komponen', 'nama_aktivitas', 'rencana_mulai', 'rencana_selesai', 'realisasi_mulai', 'realisasi_selesai', 'keterangan', 'terlaksana_id', 'status_id']);

            // 3. Menambah kolom baru di saat yang sama
            $table->string('kode')->nullable()->after('dokumen_perencanaan_id');
            $table->string('program/kegiatan/kro/ro/komponen/subkomp/detil')->nullable()->after('kode');
            $table->string('volume')->nullable()->after('program/kegiatan/kro/ro/komponen/subkomp/detil');
            $table->integer('harga_satuan')->default(0)->after('volume');
            $table->integer('jumlah_biaya')->default(0)->after('harga_satuan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perencanaans', function (Blueprint $table) {
            // 1. Hapus kolom baru yang tadi ditambahkan di fungsi up
            $table->dropColumn(['kode', 'program/kegiatan/kro/ro/komponen/subkomp/detil', 'volume', 'harga_satuan', 'jumlah_biaya']);

            // 2. Tambahkan kembali kolom lama yang tadi dihapus di fungsi up
            $table->string('komponen');
            $table->string('uraian_komponen')->nullable();
            $table->string('sub_komponen');
            $table->string('uraian_sub_komponen')->nullable();
            $table->string('nama_aktivitas');
            $table->string('rencana_mulai')->format('yyyy-mm-dd');
            $table->string('rencana_selesai')->format('yyyy-mm-dd');
            $table->string('realisasi_mulai')->format('yyyy-mm-dd')->nullable();
            $table->string('realisasi_selesai')->format('yyyy-mm-dd')->nullable();
            $table->string('keterangan')->nullable();
            $table->integer('terlaksana_id')->default('0');
            $table->unsignedBigInteger('status_id')->nullable()->after('terlaksana_id');
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('cascade');
        });
    }
};
