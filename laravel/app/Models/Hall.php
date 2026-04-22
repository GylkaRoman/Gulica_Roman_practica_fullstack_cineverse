<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hall extends Model
{
    protected $fillable = [
        'name',
        'rows_count',
        'seats_per_row',
    ];

    public function seats() 
    {
        return $this->hasMany(Seat::class);
    }
}
