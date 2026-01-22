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
        Schema::table('kepegawaians', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('kepegawaians', function (Blueprint $table) {
            // 1. Hapus foreign key constraint terlebih dahulu
            $table->dropForeign(['user_id']);
            
            // 2. Kemudian hapus kolomnya
            $table->dropColumn('user_id');
        });
    }
};
