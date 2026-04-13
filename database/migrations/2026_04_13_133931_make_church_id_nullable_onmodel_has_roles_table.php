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
        Schema::table('model_has_roles', function (Blueprint $table) {
            // Drop existing constraints first
            $table->dropPrimary(['church_id', 'role_id', 'model_uuid', 'model_type']);
            
            // Change church_id to nullable
            $table->char('church_id', 36)->nullable()->change();

            // Re-create Primary Key WITHOUT church_id
            $table->primary(['role_id', 'model_uuid', 'model_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('model_has_roles', function (Blueprint $table) {
            // Drop existing constraints first
            $table->dropPrimary(['role_id', 'model_uuid', 'model_type']);
            
            // Change church_id to nullable
            $table->char('church_id', 36)->change();

            // Re-create Primary Key WITHOUT church_id
            $table->primary(['church_id', 'role_id', 'model_uuid', 'model_type']);
        });
    }
};
