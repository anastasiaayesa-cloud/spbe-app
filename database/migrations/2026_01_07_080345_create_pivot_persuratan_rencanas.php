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
        Schema::create('pivot_persuratans_rencanas', function (Blueprint $table) {
            $table->unsignedBigInteger('persuratan_id');
            $table->unsignedBigInteger('rencana_id');

            $table->foreign('persuratan_id')->references('id')->on('persuratans')->onDelete('cascade');
            $table->foreign('rencana_id')->references('id')->on('rencanas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pivot_persuratans_rencanas');
    }
};
