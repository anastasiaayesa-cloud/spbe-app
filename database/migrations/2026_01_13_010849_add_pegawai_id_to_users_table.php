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
        Schema::table('users', function (Blueprint $table) {
            // Kita gunakan foreignId untuk konsistensi tipe data
            $table->foreignId('pegawai_id')
                ->after('id')
                ->nullable() 
                ->constrained(table: 'kepegawaians') // Sebutkan nama tabel tujuan secara eksplisit
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Penting: Hapus constraint dulu baru hapus kolom
            $table->dropForeign(['pegawai_id']);
            $table->dropColumn('pegawai_id');
        });
    }
};
