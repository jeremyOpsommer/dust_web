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
        Schema::table('oauth_tokens', function (Blueprint $table) {
            $table->string('provider_user_id')->nullable()->after('provider');
            $table->unique(['provider', 'provider_user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('oauth_tokens', function (Blueprint $table) {
            $table->dropUnique(['provider', 'provider_user_id']);
            $table->dropColumn('provider_user_id');
        });
    }
};
