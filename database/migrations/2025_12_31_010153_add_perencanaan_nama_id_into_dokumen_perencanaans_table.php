<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dokumen_perencanaans', function (Blueprint $table) {
            $table->foreign('perencanaan_nama_id')
                  ->references('id')
                  ->on('perencanaan_namas')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('dokumen_perencanaans', function (Blueprint $table) {
            try {
                $table->dropForeign(['perencanaan_nama_id']);
            } catch (\Exception $e) {
                // FK tidak ada → aman diabaikan
            }
        });
    }
};
