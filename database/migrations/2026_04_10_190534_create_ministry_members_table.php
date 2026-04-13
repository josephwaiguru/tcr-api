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
            $table->uuid('church_id')->index();

            $table->uuid('ministry_id');
            $table->uuid('user_id');

            $table->enum('role', ['leader', 'member'])->default('member');
            $table->enum('status', ['active', 'on_leave', 'removed'])->default('active');

            $table->timestamps();

            $table->unique(['ministry_id', 'user_id']);

            $table->foreign('church_id')->references('id')->on('churches')->cascadeOnDelete();
            $table->foreign('ministry_id')->references('id')->on('ministries')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
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
