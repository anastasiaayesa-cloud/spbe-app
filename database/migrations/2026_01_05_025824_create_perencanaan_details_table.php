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
        Schema::create('perencanaan_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('perencanaan_id')->constrained()->onDelete('cascade');
            $table->string('uraian_rincian'); // Contoh: Pengadaan ATK [1 keg x 1 KL]
            $table->decimal('volume', 10, 2); // Contoh: 1.0 atau 15.0
            $table->string('volume_satuan'); // Contoh: KEG, OK, atau OJ
            $table->bigInteger('harga_satuan');
            $table->bigInteger('subtotal_biaya');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perencanaan_details');
    }
};
