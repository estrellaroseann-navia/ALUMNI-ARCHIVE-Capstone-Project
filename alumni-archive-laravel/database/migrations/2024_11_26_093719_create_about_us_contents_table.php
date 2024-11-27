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
        Schema::create('about_us_contents', function (Blueprint $table) {
            $table->id();
            $table->longText('mission_text');
            $table->longText('mission_img');
            $table->longText('vision_text');
            $table->longText('vision_img');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_us_contents');
    }
};
