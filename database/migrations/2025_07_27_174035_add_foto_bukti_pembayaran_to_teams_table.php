<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            // Kolom ini bisa null karena hanya tim pertama dari bundle yang akan mengisinya
            $table->string('foto_bukti_pembayaran')->nullable()->after('asal_sekolah');
            $table->boolean('ver_bukti_bayar')->default(false);
            $table->integer('total_uang_babak2')->default(103000);
            $table->integer('poin_total_babak2')->default(0);
            $table->integer('harga_unlock')->default(100000);           
            $table->boolean("unlocked_babak2")->default(0); 
            $table->integer('uang')->default(20); 
            $table->integer('inventory_babak_2')->default(0); 
            $table->integer('level_mesin_quality')->default(1); 

        });
    }

    public function down(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->dropColumn('foto_bukti_pembayaran');
            $table->boolean('ver_bukti_bayar')->default(false);
        });
    }
};
