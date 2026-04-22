<?php

namespace App\Repositories\Impl;

use App\Models\Booking;
use App\Repositories\Interfaces\BookingRepositoryInterface;

class BookingRepository implements BookingRepositoryInterface
{

    public function create(array $data)
    {
        return Booking::create($data);
    }
}
