<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('persuratans', function (Blueprint $table) {
            $table->id();
            $table->string('kepada'); 
            $table->string('nama_surat'); // nama surat (opsional if needed)
            $table->string('file_pdf');   // simpan nama file PDF
            $table->date('tanggal_upload'); // tanggal upload
            $table->string('perihal');
            $table->enum('jenis_anggaran', ['BPMP', 'Luar BPMP', 'Anggaran Gabungan']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('persuratans');
    }
};
