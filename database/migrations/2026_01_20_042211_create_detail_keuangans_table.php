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
        Schema::create('detail_keuangans', function (Blueprint $table) {
    $table->id();
    $table->foreignId('keuangan_id')->constrained()->cascadeOnDelete();
    $table->string('uraian');
    $table->bigInteger('nominal');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_keuangans');
    }
};
