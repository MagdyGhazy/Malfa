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
            $table->foreignId('unit_id')->constrained('units')->cascadeOnDelete()->cascadeOnUpdate();
            $table->tinyInteger('room_type');
            $table->decimal('price_per_night', 10, 2);
            $table->unsignedSmallInteger('capacity');
            $table->longText('description_en')->nullable();
            $table->longText('description_ar')->nullable();
            $table->text('rules_en')->nullable();
            $table->text('rules_ar')->nullable();
            $table->tinyInteger('is_available')->default(1);
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
