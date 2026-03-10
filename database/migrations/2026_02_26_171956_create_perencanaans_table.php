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
        Schema::create('perencanaans', function (Blueprint $table) {
    $table->id();
    $table->foreignId('dokumen_perencanaan_id')->constrained()->cascadeOnDelete();
    $table->string('kode')->nullable();
    $table->string('nama');
    $table->integer('volume')->nullable();
    $table->decimal('jumlah_biaya', 15, 2)->default(0);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perencanaans');
    }
};
