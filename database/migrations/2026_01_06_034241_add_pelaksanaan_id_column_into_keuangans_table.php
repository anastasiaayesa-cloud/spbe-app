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
        Schema::table('keuangans', function (Blueprint $table) {
            $table->unsignedBigInteger('pelaksanaan_id')->nullable()->before('no_sppd');


            $table->foreign('pelaksanaan_id')->references('id')->on('pelaksanaans')->onDelete('cascade');
        });
}


public function down(): void
{
    Schema::table('keuangans', function (Blueprint $table) {
        // 1. Drop foreign key dulu
        $table->dropForeign(['pelaksanaan_id']);

        // 2. Baru drop kolomnya
        $table->dropColumn('pelaksanaan_id');
    });
}
};
