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
        Schema::table('application_accepteds', function (Blueprint $table) {
            // Remove the unique constraint on application_id
            $table->dropUnique(['application_id']);

            // Add a unique constraint on application_id only (one acceptance per application)
            $table->unique('application_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('application_accepteds', function (Blueprint $table) {
            // Remove the unique constraint on application_id
            $table->dropUnique(['application_id']);

            // Add back the original unique constraint on application_id
            $table->unique('application_id');
        });
    }
};
