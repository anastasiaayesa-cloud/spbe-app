<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rencanas', function (Blueprint $table) {
            $table->string('lokasi_kegiatan')->after('tanggal_kegiatan');
        });
    }

    public function down(): void
    {
        Schema::table('rencanas', function (Blueprint $table) {
            $table->dropColumn('lokasi_kegiatan');
        });
    }
};
