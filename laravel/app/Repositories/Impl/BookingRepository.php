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

    public function findById(int $id)
    {
        return Booking::with(['seats', 'session.movie', 'session.hall'])
            ->findOrFail($id);
    }

    public function attachSeats($booking, array $seatIds)
    {
        $booking->seats()->attach($seatIds);
    }

    public function update($booking, array $data)
    {
        $booking->update($data);
    }

    public function findWithRelations(int $id)
    {
        return Booking::with(['seats', 'session', 'user'])->findOrFail($id);
    }

    public function getBookedSeatIds(int $sessionId, array $seatIds)
    {
        return DB::table('booking_seat')
            ->join('bookings', 'bookings.id', '=', 'booking_seat.booking_id')
            ->where('bookings.session_id', $sessionId)
            ->whereIn('booking_seat.seat_id', $seatIds)
            ->pluck('seat_id')
            ->toArray();
    }
}