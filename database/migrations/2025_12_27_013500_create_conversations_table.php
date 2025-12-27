<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('conversations', function (Blueprint $col) {
            $col->id();
            $col->foreignId('user_one_id')->constrained('users')->onDelete('cascade');
            $col->foreignId('user_two_id')->constrained('users')->onDelete('cascade');
            $col->timestamp('last_message_at')->nullable();
            $col->timestamps();

            // Ensure unique conversation between two users
            $col->unique(['user_one_id', 'user_two_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
