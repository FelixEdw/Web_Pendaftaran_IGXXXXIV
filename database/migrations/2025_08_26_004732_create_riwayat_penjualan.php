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
        Schema::create('riwayat_penjualan', function (Blueprint $table) {
            $table->id();
            $table->string('peserta_namaTim');

            $table->foreign('peserta_namaTim')
                ->references('nama_tim')
                ->on('teams')
                ->onDelete('cascade');
            $table->integer('jumlah')->default(0);
            $table->string('jenis sepeda');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_penjualan');
    }
};
