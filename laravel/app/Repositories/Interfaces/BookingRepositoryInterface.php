<?php

namespace App\Repositories\Interfaces;

interface BookingRepositoryInterface
{
    public function create(array $data);
    public function getBookedSeatIds(int $sessionId, array $seatIds);
    public function getUserBookings(int $userId);
    public function findById(int $id);
    public function attachSeats($booking, array $seatIds);
    public function update($booking, array $data);
    public function findWithRelations(int $id);
}
