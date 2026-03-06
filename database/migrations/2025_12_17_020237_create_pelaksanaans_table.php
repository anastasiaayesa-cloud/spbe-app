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
            $table->string('jenis_bukti');
            $table->string('file_pdf');   // simpan nama file PDF
            $table->date('tanggal_upload'); // tanggal upload

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
