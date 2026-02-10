<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Migrate existing is_admin values to role column
        DB::statement("UPDATE users SET role = 'admin' WHERE is_admin = 1");
        
        // Drop is_admin column
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_admin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate is_admin column
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false)->after('email');
        });
        
        // Migrate role back to is_admin
        DB::statement("UPDATE users SET is_admin = 1 WHERE role = 'admin'");
    }
};
