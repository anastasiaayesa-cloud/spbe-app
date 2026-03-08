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
    Schema::table('detail_keuangans', function (Blueprint $table) {
        $table->foreignId('kepegawaian_id')
              ->after('keuangan_id')
              ->constrained('kepegawaians')
              ->cascadeOnDelete();
    });
}

public function down()
{
    Schema::table('detail_keuangans', function (Blueprint $table) {
        $table->dropForeign(['kepegawaian_id']);
        $table->dropColumn('kepegawaian_id');
    });
}

};
