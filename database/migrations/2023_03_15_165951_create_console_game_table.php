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
        Schema::create('console_game', function (Blueprint $table) {
            $table->id();

            //FK CONSOLE
            $table->unsignedBigInteger('console_id');
            $table->foreign('console_id')->references('id')->on('consoles');

            //FK GAME
            $table->unsignedBigInteger('game_id');
            $table->foreign('game_id')->references('id')->on('games');

            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('console_game');
    }
};
