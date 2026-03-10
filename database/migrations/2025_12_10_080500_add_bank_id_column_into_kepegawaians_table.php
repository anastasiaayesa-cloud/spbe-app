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
            if (!Schema::hasColumn('kepegawaians', 'bank_id')) {
                // Tambahkan kolom
                $table->unsignedBigInteger('bank_id')->nullable()->after('npwp');
                
                // Tambahkan foreign key
                $table->foreign('bank_id')->references('id')->on('banks')->onDelete('cascade');
            }
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kepegawaians', function (Blueprint $table) {
            $table->dropColumn('bank_id');
     
        });
    }
};
