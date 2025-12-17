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
        Schema::table('pelaksanaans', function (Blueprint $table) {
            $table->unsignedBigInteger('pelaksanaan_jenis_id')->nullable()->after('file_pdf');


            $table->foreign('pelaksanaan_jenis_id')->references('id')->on('pelaksanaanjenises')->onDelete('cascade');
        });

    }
public function down(): void
    {
        Schema::table('pelaksanaans', function (Blueprint $table) {
            $table->dropColumn('pelaksanaan_jenis_id');
        });
    }

};
