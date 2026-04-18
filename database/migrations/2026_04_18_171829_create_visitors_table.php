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
        Schema::create('visitors', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('church_id')->index();

            $table->string('full_name');
            $table->string('email')->nullable();
            $table->string('phone');
            $table->string('residence'); // e.g., Ruiru, Kimbo, Membley
            $table->text('prayer_request')->nullable();
            $table->boolean('converted_to_user')->default(false);
            $table->timestamps();

            $table->foreign('church_id')->references('id')->on('churches')->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};
