<?php

namespace App\Models;

use App\Enums\SessionFormat;
use App\Enums\SessionLanguage;
use Illuminate\Database\Eloquent\Model;

class MovieSession extends Model
{
    protected $fillable = [
        'movie_id',
        'hall_id',
        'date',
        'time',
        'format',
        'language',
        'base_price',
    ];

    protected $casts = [
        'format' => SessionFormat::class,
        'language' => SessionLanguage::class,
    ];

    public function movie() {
        return $this->belongsTo(Movie::class);
    }

    public function hall() {
        return $this->belongsTo(Hall::class);
    }
}