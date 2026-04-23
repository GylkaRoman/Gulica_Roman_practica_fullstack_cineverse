<?php

namespace App\Services\Interfaces;

use App\DTO\BookingDTO;

interface BookingServiceInterface
{
    public function create(BookingDTO $dto);
}
