<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('keuangans', function (Blueprint $table) {
        $table->enum('status', ['lunas', 'belum_lunas'])
              ->default('belum_lunas')
              ->after('tanggal_sppd');
    });
}

public function down()
{
    Schema::table('keuangans', function (Blueprint $table) {
        $table->dropColumn('status');
    });
}
};
