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
        Schema::table('roommate_posts', function (Blueprint $table) {
            $table->string('cleanliness_level')->nullable(); // e.g., Low, Medium, High
            $table->boolean('smoking')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('roommate_posts', function (Blueprint $table) {
            $table->dropColumn(['cleanliness_level', 'smoking']);
        });
    }
};
