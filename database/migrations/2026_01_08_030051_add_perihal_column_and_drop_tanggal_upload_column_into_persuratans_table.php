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
        Schema::table('persuratans', function (Blueprint $table) {
            $table->string('penerima_surat')->after('nama_surat')->required(); // Menambah kolom nama surat
            $table->string('kategori_surat')->after('penerima_surat')->nullable(); // Menambah kolom penerima surat
            $table->string('perihal')->after('file_pdf')->required(); // Menambah kolom perihal
            $table->enum('jenis_anggaran', ['BPMP', 'Luar BPMP']);

            $table->dropColumn('tanggal_upload'); // Menghapus kolom tanggal_upload

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('persuratans', function (Blueprint $table) {
            $table->dropColumn('penerima_surat');
            $table->dropColumn('kategori_surat');
            $table->dropColumn('perihal');
            $table->dropColumn('jenis_anggaran');
            
            $table->date('tanggal_upload')->nullable();
        });
    }
};
