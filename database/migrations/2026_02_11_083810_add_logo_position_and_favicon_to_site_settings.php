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
        // Insert default settings for logo position and favicon
        DB::table('site_settings')->insertOrIgnore([
            [
                'key' => 'logo_position',
                'value' => 'left',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'favicon',
                'value' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove the settings we added
        DB::table('site_settings')->whereIn('key', ['logo_position', 'favicon'])->delete();
    }
};
