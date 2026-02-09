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
        Schema::table('sliders', function (Blueprint $table) {
            $table->string('linkable_type')->nullable()->after('button_link');
            $table->unsignedBigInteger('linkable_id')->nullable()->after('linkable_type');
            $table->index(['linkable_type', 'linkable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->dropIndex(['linkable_type', 'linkable_id']);
            $table->dropColumn(['linkable_type', 'linkable_id']);
        });
    }
};
