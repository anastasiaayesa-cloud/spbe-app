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
        Schema::create('kepegawaians', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nip')->nullable()->unique();
            $table->string('jabatan')->nullable();
            $table->string('pangkat_id')->nullable();
            $table->string('tempat_lahir');
            $table->string('tgl_lahir')->format('yyyy-mm-dd');
            $table->string('jk_id');
            $table->integer('agama_id');
            $table->string('nama_instansi');
            $table->string('alamat_instansi')->nullable();
            $table->string('telp_instansi')->nullable();
            $table->string('kode_kabupaten');
            $table->string('hp');
            $table->string('email')->nullable()->unique();
            $table->string('npwp')->nullable();
            $table->string('bank_id')->nullable();
            $table->string('no_rek')->nullable();
            $table->string('pendidikan_terakhir_id');
            $table->string('is_bpmp')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kepegawaians');
    }
};
