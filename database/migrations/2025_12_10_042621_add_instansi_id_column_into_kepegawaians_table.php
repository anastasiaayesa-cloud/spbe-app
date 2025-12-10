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
            $table->unsignedBigInteger('instansi_id')->nullable()->after('agama');


            $table->foreign('instansi_id')->references('id')->on('instansis')->onDelete('cascade');
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
