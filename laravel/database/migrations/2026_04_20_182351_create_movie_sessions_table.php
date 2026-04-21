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
        Schema::create('movie_sessions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('movie_id')->constrained()->cascadeOnDelete();
            $table->foreignId('hall_id')->constrained()->cascadeOnDelete();

            $table->date('date');
            $table->time('time');

            $table->string('format');
            $table->string('language');

            $table->decimal('base_price', 8, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};
