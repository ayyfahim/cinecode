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
        Schema::create('movie_versions', function (Blueprint $table) {
            $table->id();
            $table->string('version_name')->nullable();
            $table->string('video_link');
            $table->string('mcck_file');
            $table->foreignId('movie_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movie_versions');
    }
};
