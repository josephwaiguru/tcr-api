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
        Schema::create('e_groups', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Using UUID as Primary Key
            $table->uuid('church_id')->index();
            $table->string('name');
            $table->text('description')->nullable();
            $table->uuid('leader_id')->nullable();
            $table->string('location');
            $table->string('meeting_date');
            $table->time('meeting_time');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->json('data')->nullable();

            $table->timestamps();

            $table->foreign('church_id')->references('id')->on('churches')->cascadeOnDelete();
            $table->foreign('leader_id')->references('id')->on('users')->nullOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('e_groups');
    }
};
