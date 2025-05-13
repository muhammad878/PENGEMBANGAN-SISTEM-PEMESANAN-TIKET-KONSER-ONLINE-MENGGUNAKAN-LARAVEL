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
        Schema::table('events', function (Blueprint $table) {
            $table->text('maps_link')->nullable()->after('location')->comment('Link Google Maps untuk lokasi event');
            $table->string('venue_image_path')->nullable()->after('poster_path')->comment('Path gambar venue/lokasi event');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['maps_link', 'venue_image_path']);
        });
    }
};
