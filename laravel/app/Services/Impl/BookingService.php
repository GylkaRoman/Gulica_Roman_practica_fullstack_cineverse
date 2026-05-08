<?php

namespace App\Services\Impl;

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

            $session = \App\Models\MovieSession::findOrFail($data['session_id']);

            $seats = \App\Models\Seat::whereIn('id', $data['seat_ids'])->get();

            $total = 0;

            foreach ($seats as $seat) {

                $type = $seat->type === 'vip'
                    ? 'vip'
                    : $data['ticket_type'];

                $price = \App\Models\Price::where('type', $type)
                    ->where('format', $session->format)
                    ->first();

                if (!$price) {
                    throw new \Exception("Price not found for {$type} / {$session->format}");
                }

                $total += $price->price;
            }

            $this->repository->update($booking, [
                'total_price' => $total,
            ]);

            return $this->repository->findWithRelations($booking->id);
        });
    }

    public function getUserBookings(int $userId)
    {
        return $this->repository->getUserBookings($userId);
    }

    public function adminIndex(?string $status, ?string $search)
    {
        return $this->repository->getAllWithFilters($status, $search);
    }

    public function pay(int $bookingId, int $userId)
    {
        return DB::transaction(function () use ($bookingId, $userId) {

            $booking = $this->repository->findById($bookingId);

            $user = \App\Models\User::find($userId);

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
