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
        Schema::create('komponen', function (Blueprint $table) {
            $table->id();
        
            $table->integer('wheel')->default(0);
            $table->integer('brake_and_pedal')->default(0);
            $table->integer('chain_and_gear')->default(0);
            $table->integer('city_frame')->default(0);
            $table->integer('folding_frame')->default(0);
            $table->integer('mountain_frame')->default(0);
            $table->integer('unicycle_frame')->default(0);

            $table->unsignedBigInteger('team_id'); // foreign key ke teams.id

            $table->foreign('team_id')
                ->references('id')
                ->on('teams')
                ->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komponen');
    }
};
