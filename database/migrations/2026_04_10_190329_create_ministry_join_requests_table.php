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
        Schema::create('ministry_join_requests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('church_id')->index();

            $table->uuid('ministry_id');
            $table->uuid('user_id');

            $table->text('skills_note')->nullable();
            $table->json('availability')->nullable();

            $table->enum('status', ['pending', 'admitted', 'declined', 'waitlist'])->default('pending');

            $table->uuid('reviewed_by')->nullable();
            $table->text('leader_note')->nullable();
            $table->timestamp('reviewed_at')->nullable();

            $table->timestamps();

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
        Schema::dropIfExists('ministry_join_requests');
    }
};
