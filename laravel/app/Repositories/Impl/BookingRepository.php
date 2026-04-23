<?php

namespace App\Repositories\Impl;

use App\Models\Booking;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use Illuminate\Support\Facades\DB;

class BookingRepository implements BookingRepositoryInterface
{

    public function create(array $data)
    {
        return Booking::create($data);
    }

    public function getBookedSeatIds(int $sessionId, array $seatIds)
    {
        return DB::table('booking_seat')
            ->join('bookings', 'booking_seat.booking_id', '=', 'bookings.id')
            ->where('bookings.session_id', $sessionId)
            ->whereIn('booking_seat.seat_id', $seatIds)
            ->lockForUpdate()
            ->pluck('seat_id')
            ->toArray();
    }

    public function getUserBookings(int $userId) {
        return Booking::with([
            'session.movie',
            'session.hall',
            'seats',
        ])
        ->where('user_id', $userId)
        ->latest()
        ->get();
    }
}