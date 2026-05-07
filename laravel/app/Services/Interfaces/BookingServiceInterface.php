<?php

namespace App\Services\Interfaces;

interface BookingServiceInterface
{
    public function create(array $data, int $userId);

    public function getUserBookings(int $userId);

    public function pay(int $bookingId, int $userId);

    public function destroy(int $id);

    public function adminIndex(?string $status, ?string $search);
}