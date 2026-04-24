<?php

namespace App\Services\Interfaces;

use App\DTO\BookingDTO;

interface BookingServiceInterface
{
    public function create(array $data, int $userId);

    public function getUserBookings(int $userId);

    public function pay(int $bookingId, int $userId);
}
