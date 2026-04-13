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
        Schema::create('events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('church_id')->index();

            $table->string('title');
            $table->text('description')->nullable();

            $table->timestamp('starts_at');
            $table->timestamp('ends_at')->nullable();

            $table->integer('capacity')->nullable();
            $table->integer('rsvp_count')->default(0);

            $table->uuid('created_by')->nullable();

            $table->timestamps();

            $table->foreign('church_id')->references('id')->on('churches')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
