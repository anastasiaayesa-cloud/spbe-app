<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('perencanaans', function (Blueprint $table) {
            // hapus foreign key dulu
            $table->dropForeign(['perencanaan_nama_id']);
            // lalu hapus kolom
            $table->dropColumn('perencanaan_nama_id');
        });
    }

    public function down(): void
    {
        Schema::table('perencanaans', function (Blueprint $table) {
            $table->unsignedBigInteger('perencanaan_nama_id');

            $table->foreign('perencanaan_nama_id')
                  ->references('id')
                  ->on('perencanaan_namas')
                  ->onDelete('cascade');
        });
    }
};
