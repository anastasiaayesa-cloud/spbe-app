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
        Schema::table('perencanaans', function (Blueprint $table) {
            //1. Menghapus kolom harga satuan dan detail
            $table->dropColumn(['harga_satuan', 'detail']);
            //2. Mengubah tipe menjadi desimal
            $table->decimal('jumlah_biaya', 15, 2)->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perencanaans', function (Blueprint $table) {
            //1. Menambahkan kembali harga_satuan dan detail
            $table->decimal('harga_satuan', 15, 2);
            $table->string('detail');

            //2. Mengubah kembali tipe menjadi string
            $table->string('jumlah_biaya')->change();
        });
    }
};
