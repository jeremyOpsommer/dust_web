<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('wow_instances', function (Blueprint $table) {
            $table->unsignedInteger('expansion_id')->nullable()->after('blizzard_id');
            $table->string('expansion_name_en')->nullable()->after('expansion_id');
            $table->string('expansion_name_fr')->nullable()->after('expansion_name_en');
            $table->string('season')->nullable()->after('expansion_name_fr');
        });
    }

    public function down(): void
    {
        Schema::table('wow_instances', function (Blueprint $table) {
            $table->dropColumn(['expansion_id', 'expansion_name_en', 'expansion_name_fr', 'season']);
        });
    }
};
