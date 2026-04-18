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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('original_title');

            $table->text('description');

            $table->string('poster_url');
            $table->string('trailer_url');

            $table->string('genre');
            
            $table->integer('duration');
            
            $table->string('age_rating');
            
            $table->string('director');
            $table->string('actors');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
