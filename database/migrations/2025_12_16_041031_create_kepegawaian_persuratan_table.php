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
        Schema::create('kepegawaian_persuratan', function (Blueprint $table) {
            $table->unsignedBigInteger('kepegawaian_id');
            $table->unsignedBigInteger('persuratan_id');

            $table->foreign('kepegawaian_id')->references('id')->on('kepegawaians')->onDelete('cascade');
            $table->foreign('persuratan_id')->references('id')->on('persuratans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kepegawaian_persuratan');
    }
};
