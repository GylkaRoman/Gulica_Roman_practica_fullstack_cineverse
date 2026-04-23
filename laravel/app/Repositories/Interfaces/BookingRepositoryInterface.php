<?php

namespace App\Repositories\Interfaces;

interface BookingRepositoryInterface
{
    public function create(array $data);

    public function getBookedSeatIds(int $sessionId, array $seatIds);
}
