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
        Schema::create('penugasans', function (Blueprint $table) {
            $table->id();
            $table->string('pegawai');
            $table->string('nama_tugas');
            $table->string('deskripsi')->nullable();
            $table->string('tanggal_mulai')->format('yyyy-mm-dd');
            $table->string('tanggal_selesai')->format('yyyy-mm-dd');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penugasans');
    }
};
