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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('accommodation_id')->constrained('accommodations')->onDelete('cascade');
            $table->string('name', 100);
            $table->string('room_code', 50)->unique();
            $table->string('description')->nullable();
            $table->string('image_url')->nullable();
            $table->enum('type', ['single', 'double', 'suite', 'family']);
            $table->integer('capacity')->default(1);
            $table->unsignedInteger('price')->default(0)->comment('Price in cents');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
