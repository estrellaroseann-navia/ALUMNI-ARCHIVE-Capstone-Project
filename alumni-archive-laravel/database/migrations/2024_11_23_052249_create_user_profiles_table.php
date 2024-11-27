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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('program_id');
            $table->unsignedBigInteger('campus_id');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('employment_status')->nullable();
            $table->longText('complete_address')->nullable();
            $table->longText('city')->nullable();
            $table->string('province')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->nullable();
            $table->string('graduate_year')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('campus_id')->references('id')->on('campuses')->onDelete('cascade');
            $table->foreign('program_id')->references('id')->on('programs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
