<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wow_instances', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('blizzard_id')->unique();
            $table->string('name_en');
            $table->string('name_fr')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wow_instances');
    }
};
