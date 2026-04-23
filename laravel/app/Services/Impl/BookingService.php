<?php

namespace App\Services\Impl;

use App\DTO\BookingDTO;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use App\Services\Interfaces\BookingServiceInterface;
use Illuminate\Support\Facades\DB;

class BookingService implements BookingServiceInterface
{

    public function __construct(
        private BookingRepositoryInterface $repository
    ) {}

    public function create(BookingDTO $dto)
    {
        return DB::transaction(function () use ($dto) {

            $bookedSeats = $this->repository->getBookedSeatIds(
                $dto->sessionId,
                $dto->seatIds
            );

            if (!empty($bookedSeats)) {
                throw new \Exception(
                    'Seats already booked: ' . implode(',', $bookedSeats)
                );
            }

            $booking = $this->repository->create([
                'user_id' => $dto->userId,
                'session_id' => $dto->sessionId,
                'status' => 'pending',
                'total_price' => 0,
            ]);

            $booking->seats()->attach($dto->seatIds);

            $pricePerSeat = 100;
            $booking->total_price = count($dto->seatIds) * $pricePerSeat;
            $booking->save();

            return $booking;
        });
    }

    public function getUserBookings(int $userId) {
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
}
