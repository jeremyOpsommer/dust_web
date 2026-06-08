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
        Schema::table('wow_characters', function (Blueprint $table) {
            $table->json('stats')->nullable()->after('region');
            $table->json('equipment')->nullable()->after('stats');
            $table->json('pve_progression')->nullable()->after('equipment');
            $table->timestamp('last_refreshed_at')->nullable()->after('pve_progression');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wow_characters', function (Blueprint $table) {
            $table->dropColumn(['stats', 'equipment', 'pve_progression', 'last_refreshed_at']);
        });
    }
};
