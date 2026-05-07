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
            ->join('bookings', 'bookings.id', '=', 'booking_seat.booking_id')
            ->where('bookings.session_id', $sessionId)
            ->where('bookings.status', 'paid')
            ->whereIn('booking_seat.seat_id', $seatIds)
            ->pluck('seat_id')
            ->toArray();
    }

    public function getUserBookings(int $userId)
    {
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
        $booking->seats()->syncWithoutDetaching($seatIds);
    }

    public function update($booking, array $data)
    {
        $booking->update($data);
    }

    public function findWithRelations(int $id)
    {
        return Booking::with(['seats', 'session', 'user'])->findOrFail($id);
    }

    public function findPendingForUser(int $id, int $userId)
    {
        return Booking::where('id', $id)
            ->where('user_id', $userId)
            ->where('status', 'pending')
            ->first();
    }

    public function delete(Booking $booking)
    {
        return $booking->delete();
    }

    public function getAllWithFilters(?string $status, ?string $search)
    {
        $query = Booking::with(['user','session.movie','session.hall','seats']);

        if ($status) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            });
        }

        return $query->latest()->get();
    }

    public function markSeatsAsBooked(int $sessionId, array $seatIds)
    {
        return DB::table('seats')
            ->where('session_id', $sessionId)
            ->whereIn('id', $seatIds)
            ->update([
                'is_booked' => true
            ]);
    }
}