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
        Schema::create('course_enrollments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('church_id')->index();

            $table->uuid('course_id');
            $table->uuid('user_id');

            $table->enum('status', ['pending', 'approved', 'completed'])->default('pending');

            $table->timestamps();

            $table->unique(['course_id', 'user_id']);

            $table->foreign('church_id')->references('id')->on('churches')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_enrollments');
    }
};
