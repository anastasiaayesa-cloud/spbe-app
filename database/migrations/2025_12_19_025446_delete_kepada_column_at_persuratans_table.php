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
            // Tambahkan pengecekan if di sini
            if (Schema::hasColumn('persuratans', 'kepada')) {
                $table->dropColumn('kepada');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('persuratans', function (Blueprint $table) {
            if (!Schema::hasColumn('persuratans', 'kepada')) {
                $table->string('kepada')->after('id');
            }
        });
    }
};