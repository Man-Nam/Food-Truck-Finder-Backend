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
        Schema::create('food_trucks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type'); // e.g., "Burger Truck", "Taco Stand"
            $table->text('description')->nullable();
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->timestamp('last_reported_at')->nullable();
            $table->foreignId('reported_by_user_id')->nullable()->constrained('users')->onDelete('set null'); // User who last reported
            $table->string('marker_icon_url')->nullable(); // URL for custom marker icon
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food_trucks');
    }
};