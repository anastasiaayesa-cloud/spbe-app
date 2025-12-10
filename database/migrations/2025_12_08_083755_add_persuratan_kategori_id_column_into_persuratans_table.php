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
            $table->unsignedBigInteger('persuratan_kategori_id')->nullable();
            $table->foreign('persuratan_kategori_id')->references('id')->on('persuratan_kategoris')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('persuratans', function (Blueprint $table) {
            $table->dropColumn('persuratan_kategori_id');

        });
    }
};
