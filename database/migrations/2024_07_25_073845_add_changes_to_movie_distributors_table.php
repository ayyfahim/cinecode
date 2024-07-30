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
        Schema::table('movie_distributors', function (Blueprint $table) {
            $table->dropForeign(['distributor_id']);
            $table->dropForeign(['movie_id']);

            // Re-create the foreign key constraint with the desired behavior
            $table->foreign('distributor_id')->references('id')->on('distributors')->noActionOnDelete();


            // Re-create the foreign key constraint with the desired behavior
            $table->foreign('movie_id')->references('id')->on('movies')->noActionOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movie_distributors', function (Blueprint $table) {
            //
        });
    }
};
