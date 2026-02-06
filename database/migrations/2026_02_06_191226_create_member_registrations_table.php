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
        Schema::create('member_registrations', function (Blueprint $table) {
            $table->id();
            // Parish info
            $table->string('parish');
            
            // Personal data
            $table->string('full_name');
            $table->text('address');
            $table->string('phone');
            $table->string('email');
            $table->date('birth_date');
            $table->string('marital_status');
            $table->string('profession');
            
            // Parish data
            $table->string('member_city');
            $table->string('member_parish');
            $table->date('baptism_date')->nullable();
            
            // Commitments
            $table->boolean('commitment_1')->default(false);
            $table->boolean('commitment_2')->default(false);
            $table->boolean('commitment_3')->default(false);
            $table->boolean('commitment_4')->default(false);
            $table->boolean('commitment_5')->default(false);
            
            // Additional info
            $table->text('how_met')->nullable();
            $table->text('why_join')->nullable();
            
            // Status
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_registrations');
    }
};
