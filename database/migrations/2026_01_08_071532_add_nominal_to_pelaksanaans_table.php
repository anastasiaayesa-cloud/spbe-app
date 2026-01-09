<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('pelaksanaans', function (Blueprint $table) {
            $table->decimal('nominal', 15, 2)->nullable()->after('pelaksanaan_jenis_id');
        });
    }

    public function down()
    {
        Schema::table('pelaksanaans', function (Blueprint $table) {
            $table->dropColumn('nominal');
        });
    }
};
