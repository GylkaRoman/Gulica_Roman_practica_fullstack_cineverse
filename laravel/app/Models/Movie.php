<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        'title',
        'original_title',
        'description',
        'poster_url',
        'trailer_url',
        'genre',
        'duration',
        'age_rating',
        'director',
        'actors',
    ];
}
