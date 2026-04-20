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
        Schema::create('ministry_members', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('ministry_id')->constrained('ministries')->cascadeOnDelete();
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();

            $table->foreignUuid('role_id')->constrained('roles'); 
            $table->string('status', 20)->default('active');

            $table->timestamps();

            $table->unique(['ministry_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ministry_members');
    }
};
