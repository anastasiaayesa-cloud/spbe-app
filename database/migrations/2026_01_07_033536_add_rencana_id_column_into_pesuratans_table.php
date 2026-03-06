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
            $table->unsignedBigInteger('rencana_id')->nullable()->before('jenis_anggaran');


            $table->foreign('rencana_id')->references('id')->on('rencanas')->onDelete('cascade');
        });
}


public function down(): void
{
    Schema::table('keuangans', function (Blueprint $table) {
        // 1. Drop foreign key dulu
        $table->dropForeign(['rencana_id']);

        // 2. Baru drop kolomnya
        $table->dropColumn('rencana_id');
    });
}
};
