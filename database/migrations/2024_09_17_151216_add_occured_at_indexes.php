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
        Schema::table('impressions', function (Blueprint $table) {
            $table->index(['campaign_id', 'occurred_at']);
            $table->index('campaign_id');
        });

        Schema::table('interactions', function (Blueprint $table) {
            $table->index(['campaign_id', 'occurred_at']);
            $table->index('campaign_id');
        });

        Schema::table('conversions', function (Blueprint $table) {
            $table->index(['campaign_id', 'occurred_at']);
            $table->index('campaign_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('impressions', function (Blueprint $table) {
            $table->dropIndex('impressions_campaign_id_occurred_at_index');
            $table->dropIndex('impressions_campaign_id_index');
        });

        Schema::table('interactions', function (Blueprint $table) {
            $table->dropIndex('interactions_campaign_id_occurred_at_index');
            $table->dropIndex('interactions_campaign_id_index');
        });

        Schema::table('conversions', function (Blueprint $table) {
            $table->dropIndex('conversions_campaign_id_occurred_at_index');
            $table->dropIndex('conversions_campaign_id_index');
        });
    }
};
