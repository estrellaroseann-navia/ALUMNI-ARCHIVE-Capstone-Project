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
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->year('graduation_year'); // Graduation year
            $table->string('program')->nullable(); // Degree or program completed
            $table->string('employment_status')->nullable(); // Employed, Unemployed, Self-employed
            $table->string('company_name')->nullable(); // Company name if employed
            $table->string('job_title')->nullable(); // Job title if employed
            $table->boolean('is_job_related_to_degree')->nullable(); // Is the job related to their degree? (Yes/No)
            $table->text('feedback_on_education')->nullable(); // Feedback on how the degree helped in their career
            $table->text('skills_needed')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surveys');
    }
};
