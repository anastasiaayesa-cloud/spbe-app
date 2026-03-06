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
        Schema::table('pelaksanaans', function (Blueprint $table) {
            $table->unsignedBigInteger('pelaksanaan_jenis_id')
                  ->nullable()
                  ->after('file_pdf');

            $table->foreign('pelaksanaan_jenis_id')
                  ->references('id')
                  ->on('pelaksanaan_jenis')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pelaksanaans', function (Blueprint $table) {
            // hapus FK dulu
            $table->dropForeign(['pelaksanaan_jenis_id']);

            // baru hapus kolom
            $table->dropColumn('pelaksanaan_jenis_id');
        });
    }
};
