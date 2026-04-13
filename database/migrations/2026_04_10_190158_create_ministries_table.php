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
        Schema::create('ministries', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('church_id')->index();

            $table->string('name');
            $table->text('description')->nullable();
            $table->uuid('leader_id')->nullable();

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
        Schema::dropIfExists('ministries');
    }
};
