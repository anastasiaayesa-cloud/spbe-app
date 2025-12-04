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
            $table->string('komponen');
            $table->string('uraian_komponen')->nullable();
            $table->string('sub_komponen');
            $table->string('uraian_sub_komponen')->nullable();
            $table->string('nama_aktivitas');
            $table->string('rencana_mulai')->format('yyyy-mm-dd');
            $table->string('rencana_selesai')->format('yyyy-mm-dd');
            $table->string('realisasi_mulai')->format('yyyy-mm-dd')->nullable();
            $table->string('realisasi_selesai')->format('yyyy-mm-dd')->nullable();
            $table->string('keterangan')->nullable();
            $table->integer('terlaksana_id')->default('0');
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
