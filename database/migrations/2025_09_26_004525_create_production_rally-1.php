<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('production_rally1', function (Blueprint $table) {
            $table->id();

            // Relasi ke tim
            $table->foreignId('team_id')
                ->constrained('teams')
                ->onDelete('cascade');
            $table->integer('total_komponen_diperoleh')->default(0);
            $table->integer('total_komponen_terpakai')->default(0);
            $table->integer('output_aktual')->default(0);
            $table->decimal('revenue', 15, 2)->default(0);
            $table->float('production_efficiency')->default(0);
            $table->float('time_productivity')->default(0);
            $table->float('performance')->default(0);
            $table->float('poin_total')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('production_rally1');
    }
};
