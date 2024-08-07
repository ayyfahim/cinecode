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
        Schema::table('distributor_emails', function (Blueprint $table) {
            $table->dropForeign(['distributor_id']);

            // Re-create the foreign key constraint with the desired behavior
            $table->foreign('distributor_id')->references('id')->on('distributors')->noActionOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('distributor_emails', function (Blueprint $table) {
            //
        });
    }
};
