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
            $table->unsignedBigInteger('pangkat_id')->nullable()->after('jabatan');

            $table->foreign('pangkat_id')->references('id')->on('pangkats')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kepegawaians', function (Blueprint $table) {
            $table->dropColumn('pangkat_id');
        });
    }
};
