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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->morphs('staffable');
            $table->foreignId('staff_id')->constrained('staffs')->cascadeOnDelete();
            $table->foreignId('guest_id')->constrained('guests')->cascadeOnDelete();
            $table->foreignId('vehicle_id')->constrained('vehicles')->cascadeOnDelete();
            $table->unsignedInteger('passengers');
            $table->string('description', 100)->nullable();
            $table->dateTime('pickup_at');
            $table->dateTime('dropped_off_at');
            $table->dateTime('actual_pickup_at')->nullable();
            $table->dateTime('actual_dropped_off_at')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'for pick up', 'in transit', 'dropped off', 'cancelled', 'invalid']);
            $table->timestamps();
            
            $table->unique(['staffable_type', 'staffable_id', 'staff_id', 'guest_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
