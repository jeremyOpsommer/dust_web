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
        Schema::create('wow_characters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('blizzard_id');
            $table->string('name');
            $table->string('realm_slug');
            $table->string('realm_name');
            $table->string('class_name');
            $table->unsignedTinyInteger('level');
            $table->string('region', 10)->default('eu');
            $table->timestamps();

            $table->unique(['user_id', 'blizzard_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wow_characters');
    }
};
