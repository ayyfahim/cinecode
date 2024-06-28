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
        Schema::table('cinemas', function (Blueprint $table) {
            $table->dropColumn(['city', 'country']);

            $table->string('city_name');
            $table->unsignedBigInteger('country_id');
            $table->string('unique_hash')->nullable()->change();
            $table->dateTime('downloaded_player')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cinemas', function (Blueprint $table) {
            //
        });
    }
};
