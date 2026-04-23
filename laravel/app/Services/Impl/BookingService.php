<?php

namespace App\Services\Impl;

use App\DTO\BookingDTO;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use App\Services\Interfaces\BookingServiceInterface;

class BookingService implements BookingServiceInterface
{

    public function __construct(
        private BookingRepositoryInterface $repository
    ) {}

    public function create(BookingDTO $dto)
    {
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
    }

}
