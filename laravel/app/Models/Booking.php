<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'session_id',
        'total_price',
        'status',
    ];

    public function seats() 
    {
        return $this->belongsToMany(Seat::class, 'booking_seat');
    }

    public function session() 
    {
        return $this->belongsTo(MovieSession::class, 'session_id');
    }

    public function user() 
    {
        return $this->belongsTo(User::class);
    }
}
