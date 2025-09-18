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
        Schema::table('flight_options', function (Blueprint $table) {
         $table->foreign('flight_id')
              ->references('id')
              ->on('flights')
              ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('flight_id_on_flight_options', function (Blueprint $table) {
            //
        });
    }
};
