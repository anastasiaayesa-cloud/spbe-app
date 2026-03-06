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
            $table->unsignedBigInteger('dokumen_perencanaan_id')->nullable()->after('status_id');
            $table->foreign('dokumen_perencanaan_id')->references('id')->on('dokumen_perencanaans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perencanaans', function (Blueprint $table) {
            $table->dropColumn('dokumen_perencanaan_id');
        });
    }
};
