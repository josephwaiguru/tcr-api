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
        Schema::create('e_group_join_requests', function (Blueprint $table) {
            $table->uuid('id')->primary();
    $table->foreignUuid('e_group_id')->constrained('e_groups')->cascadeOnDelete();
    $table->foreignUuId('user_id')->constrained('users')->cascadeOnDelete(); // Assuming Users still use BigInt IDs
    $table->string('status')->default('pending');
    $table->text('notes')->nullable();
    $table->timestamps();
    
    $table->unique(['e_group_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('e_group_join_requests');
    }
};
