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
            $table->foreignUuid('user_uuid')->constrained('users', 'uuid');
            $table->foreignId('deck_id')->constrained();
            $table->unsignedTinyInteger('player_score')->nullable();
            $table->unsignedTinyInteger('dealer_score')->nullable();
            $table->enum('result', ['win', 'loss', 'tie'])->nullable();
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
