<?php

namespace App\Services\Impl;

use App\DTO\BookingDTO;
use App\Models\Booking;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use App\Services\Interfaces\BookingServiceInterface;
use Illuminate\Support\Facades\DB;

class BookingService implements BookingServiceInterface
{

    public function __construct(
        private BookingRepositoryInterface $repository
    ) {}

    public function create(array $data, int $userId)
    {
        return DB::transaction(function () use ($data, $userId) {

            $bookedSeats = $this->repository->getBookedSeatIds(
                $data['session_id'],
                $data['seat_ids']
            );

            if (!empty($bookedSeats)) {
                throw new \Exception(
                    'Seats already booked: ' . implode(',', $bookedSeats)
                );
            }

            $booking = $this->repository->create([
                'user_id' => $userId,
                'session_id' => $data['session_id'],
                'status' => 'pending',
                'total_price' => 0,
            ]);

            $this->repository->attachSeats($booking, $data['seat_ids']);

            $pricePerSeat = 100;

            $this->repository->update($booking, [
                'total_price' => count($data['seat_ids']) * $pricePerSeat,
            ]);

            return $this->repository->findWithRelations($booking->id);
        });
    }

    public function getUserBookings(int $userId)
    {
        $bookings = $this->repository->getUserBookings($userId);

        return $bookings->map(function ($booking) {
            return [
                'id' => $booking->id,
                'movie' => $booking->session->movie->title,
                'date' => $booking->session->date,
                'time' => $booking->session->time,
                'hall' => $booking->session->hall->name,

                'seats' => $booking->seats->map(function ($seat) {
                    return [
                        'row' => $seat->row_number,
                        'number' => $seat->seat_number,
                    ];
                }),

                'total_price' => $booking->total_price,
                'status' => $booking->status,
            ];
        });
    }

    public function adminIndex(?string $status, ?string $search)
    {
        return $this->repository->getAllWithFilters($status, $search);
    }

    public function pay(int $bookingId, int $userId)
    {
        return DB::transaction(function () use ($bookingId, $userId) {

            $booking = $this->repository->findById($bookingId);

            $user = \App\Models\User::find(auth('api')->id());

            if ($booking->user_id !== $userId) {
                throw new \Exception('Forbidden');
            }

            if ($booking->status === 'paid') {
                throw new \Exception('Already paid');
            }

            if ($user->balance < $booking->total_price) {
                throw new \Exception('Not enough balance');
            }

            $user->balance -= $booking->total_price;
            $user->save();

            $booking->status = 'paid';
            $booking->save();

            return $booking;
        });
    }
    public function destroy(int $id)
    {
        $booking = $this->repository->findPendingForUser($id, auth('api')->id());

        if (!$booking) {
            throw new \Exception('Booking not found or not allowed');
        }

        $this->repository->delete($booking);
    }
}
