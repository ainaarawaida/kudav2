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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('slot_horse');
        Schema::create('slot_horse', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('slot_id')->nullable();
            $table->unsignedBigInteger('horse_id')->nullable();
            $table->unsignedBigInteger('coach_id')->nullable();
            $table->unsignedBigInteger('rider_id')->nullable();
            $table->foreign('slot_id')->references('id')->on('slots');
            $table->foreign('horse_id')->references('id')->on('horses');
            $table->foreign('coach_id')->references('id')->on('coaches');
            $table->foreign('rider_id')->references('id')->on('riders');
            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();
            
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slot_horse');
    }
};
