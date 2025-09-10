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
        Schema::create('waiting_list_pos', function (Blueprint $table) {
            $table->id();
            $table->string('peserta_namaTim');
            $table->foreign('peserta_namaTim')
                ->references('nama_tim')
                ->on('teams')
                ->onDelete('cascade');
            $table->unsignedBigInteger('pos_id');
            $table->foreign('pos_id')->references('id')->on('pos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waiting_list_pos');
    }
};
