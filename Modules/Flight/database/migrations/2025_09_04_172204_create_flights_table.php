<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Company\Models\Airport;
use Modules\Company\Models\Company;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->integer('load');
            $table->string('number');
            $table->string('plane');
            $table->tinyInteger('discount')->nullable();
            $table->foreignId('origin_airport')->constrained('airports')->cascadeOnDelete();
            $table->foreignId('destination_airport')->constrained('airports')->cascadeOnDelete();
            $table->foreignIdFor(Company::class)->constrained()->cascadeOnDelete();
            $table->string('slug')->unique()->nullable();
            $table->string('date');
            $table->string('timeStart');
            $table->string('timeEnd');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
