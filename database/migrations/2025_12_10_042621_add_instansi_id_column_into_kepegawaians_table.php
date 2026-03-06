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
        Schema::table('kepegawaians', function (Blueprint $table) {
            // Periksa apakah kolom 'bank_id' BELUM ADA sebelum menambahkannya.
            if (!Schema::hasColumn('kepegawaians', 'instansi_id')) {
                // Tambahkan kolom
                $table->unsignedBigInteger('instansi_id')->nullable()->after('agama');
                
                // Tambahkan foreign key
                $table->foreign('instansi_id')->references('id')->on('instansis')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kepegawaians', function (Blueprint $table) {
            $table->dropColumn('instansi_id');
        });
    }
};
