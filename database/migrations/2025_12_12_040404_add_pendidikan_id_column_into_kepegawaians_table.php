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
        Schema::table('kepegawaians', function (Blueprint $table) {
            $table->unsignedBigInteger('pendidikan_id')->nullable()->after('no_rek');


            $table->foreign('pendidikan_id')->references('id')->on('pendidikans')->onDelete('cascade');
        });
    }

public function down(): void
    {
        Schema::table('kepegawaians', function (Blueprint $table) {
            $table->dropColumn('pendidikan_id');
        });
    }

};
