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
        Schema::table('user_profiles', function (Blueprint $table) {
            // Make the program_id column nullable
            $table->unsignedBigInteger('program_id')->nullable()->change();
            $table->unsignedBigInteger('campus_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            // Revert program_id back to non-nullable
            $table->unsignedBigInteger('program_id')->nullable(false)->change();
            $table->unsignedBigInteger('campus_id')->nullable(false)->change();
        });
    }
};
