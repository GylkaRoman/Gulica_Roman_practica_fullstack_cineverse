<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
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

    public function movie() {
        return $this->belongsTo(Movie::class);
    }

    public function hall() {
        return $this->belongsTo(Hall::class);
    }
}