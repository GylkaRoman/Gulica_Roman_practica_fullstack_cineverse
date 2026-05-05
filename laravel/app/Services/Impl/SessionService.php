<?php

namespace App\Services\Impl;

use App\DTO\SessionDTO;
use App\Repositories\Interfaces\SessionRepositoryInterface;
use App\Services\Interfaces\SessionServiceInterface;
use Illuminate\Support\Facades\DB;

class SessionService implements SessionServiceInterface
{
    public function __construct(
        private SessionRepositoryInterface $repository
    ) {}

    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    public function update(int $id, array $data)
    {
        $session = $this->repository->findById($id);
        return $this->repository->update($session, $data);
    }

    public function delete(int $id)
    {
        $session = $this->repository->findById($id);
        return $this->repository->delete($session);
    }

    public function getAll(int $perPage, ?string $date = null)
    {
        return $this->repository->getAll($perPage, $date);
    }

    public function getSeats(int $sessionId)
    {
        $session = $this->repository->getSeats($sessionId);

        $bookedSeatIds = DB::table('booking_seat')
            ->join('bookings', 'booking_seat.booking_id', '=', 'bookings.id')
            ->where('bookings.session_id', $sessionId)
            ->pluck('seat_id')
            ->toArray();

        return [
            'session_id' => $session->id,
            'movie_id' => $session->movie_id,
            'hall' => [
                'id' => $session->hall->id,
                'name' => $session->hall->name,
                'rows' => $session->hall->rows_count,
                'seats_per_row' => $session->hall->seats_per_row,
            ],
            'seats' => $session->hall->seats->map(function ($seat) use ($bookedSeatIds) {
                return [
                    'id' => $seat->id,
                    'row' => $seat->row_number,
                    'number' => $seat->seat_number,
                    'type' => $seat->type,
                    'is_booked' => in_array($seat->id, $bookedSeatIds),
                ];
            }),
        ];
    }
}
