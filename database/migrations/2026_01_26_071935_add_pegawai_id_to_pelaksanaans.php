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
        if (! Schema::hasColumn('pelaksanaans', 'kepegawaian_id')) {
            $table->unsignedBigInteger('kepegawaian_id')
                  ->nullable()
                  ->after('rencana_id');
        }
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('pelaksanaans', function (Blueprint $table) {
        if (Schema::hasColumn('pelaksanaans', 'kepegawaian_id')) {
            $table->dropColumn('kepegawaian_id');
        }
    });
}
};
