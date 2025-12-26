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
        // Create preferences table
        Schema::create('preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('roommate_post_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
        });
        // Remove old columns from roommate_posts
        Schema::table('roommate_posts', function (Blueprint $table) {
            $table->dropColumn(['cleanliness_level', 'smoking']);
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preferences');
        Schema::table('roommate_posts', function (Blueprint $table) {
            $table->string('cleanliness_level')->nullable();
            $table->boolean('smoking')->default(false);
            $table->boolean('quiet_hours')->default(false);
        });
    }
};