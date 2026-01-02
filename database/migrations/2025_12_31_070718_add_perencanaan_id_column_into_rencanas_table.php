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
        Schema::table('rencanas', function (Blueprint $table) {
            $table->unsignedBigInteger('perencanaan_id')->nullable()->after('nama_kegiatan');


            $table->foreign('perencanaan_id')->references('id')->on('perencanaans')->onDelete('cascade');
        });
}


public function down(): void
{
    Schema::table('rencanas', function (Blueprint $table) {
        // 1. Drop foreign key dulu
        $table->dropForeign(['perencanaan_id']);

        // 2. Baru drop kolomnya
        $table->dropColumn('perencanaan_id');
    });
}

};
