<?php

namespace App\Services\Impl;

use App\DTO\SessionDTO;
use App\Repositories\Interfaces\SessionRepositoryInterface;
use App\Services\Interfaces\SessionServiceInterface;

class SessionService implements SessionServiceInterface
{
    public function __construct(
        private SessionRepositoryInterface $repository
    ) {}

    public function create(SessionDTO $dto)
    {
        return $this->repository->create($dto);
    }

    public function getAll(int $perPage, ?string $date = null)
    {
        return $this->repository->getAll($perPage, $date);
    }

    public function getSeats(int $sessionId)
{
    $session = $this->repository->getSeats($sessionId);

    return [
        'session_id' => $session->id,
        'movie_id' => $session->movie_id,
        'hall' => [
            'id' => $session->hall->id,
            'name' => $session->hall->name,
            'rows' => $session->hall->rows_count,
            'seats_per_row' => $session->hall->seats_per_row,
        ],
        'seats' => $session->hall->seats->map(function ($seat) {
            return [
                'id' => $seat->id,
                'row' => $seat->row_number,
                'number' => $seat->seat_number,
                'type' => $seat->type,
            ];
        }),
    ];
}
}
