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
        Schema::create('perencanaan_rencana', function (Blueprint $table) {
    $table->id();

    $table->foreignId('perencanaan_id')
        ->constrained()
        ->cascadeOnDelete();

    $table->foreignId('rencana_id')
        ->constrained()
        ->cascadeOnDelete();

    $table->timestamps();

    $table->unique(['perencanaan_id', 'rencana_id']);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perencanaan_rencana');
    }
};
