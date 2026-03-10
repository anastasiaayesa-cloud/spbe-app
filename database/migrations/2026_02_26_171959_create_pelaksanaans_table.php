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
        Schema::create('pelaksanaans', function (Blueprint $table) {
    $table->id();
    $table->foreignId('rencana_id')->constrained()->cascadeOnDelete();
    $table->foreignId('kepegawaian_id')->constrained()->cascadeOnDelete();
    $table->foreignId('pelaksanaan_jenis_id')->constrained('pelaksanaan_jenis');
    $table->string('file_pdf')->nullable();
    $table->string('file_type')->nullable();
    $table->date('tanggal_upload')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelaksanaans');
    }
};
