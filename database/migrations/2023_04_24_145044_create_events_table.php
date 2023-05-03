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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['gól', 'öngól', 'sárga lap', 'piros lap']);
            $table->integer('minute');
            $table->timestamps();

            $table->foreignId('game_id')->constrained('games')->onDelete('cascade');

            $table->foreignId('player_id')->constrained('players')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
