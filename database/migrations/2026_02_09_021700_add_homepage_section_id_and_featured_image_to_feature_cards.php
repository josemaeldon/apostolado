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
        Schema::table('feature_cards', function (Blueprint $table) {
            $table->foreignId('homepage_section_id')->nullable()->after('id')->constrained('homepage_sections')->onDelete('cascade');
            $table->string('featured_image')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('feature_cards', function (Blueprint $table) {
            $table->dropForeign(['homepage_section_id']);
            $table->dropColumn('homepage_section_id');
            $table->dropColumn('featured_image');
        });
    }
};
