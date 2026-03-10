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
            $table->unsignedBigInteger('kepegawaian_id')->nullable()->before('no_sppd');


            $table->foreign('kepegawaian_id')->references('id')->on('kepegawaians')->onDelete('cascade');
        });
}


public function down(): void
{
    Schema::table('keuangans', function (Blueprint $table) {
        // 1. Drop foreign key dulu
        $table->dropForeign(['kepegawaian_id']);

        // 2. Baru drop kolomnya
        $table->dropColumn('kepegawaian_id');
    });
}
};
