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
        Schema::create('games', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('description');
            $table->float('price');
            $table->string('product');
            // PER AGGIUNGERE CREARE UNA NUOVA MIGRAZIONE
            // MAKE:MIGRATION ADD_COVER_COLUMN_TO_GAMES_TABLE


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
