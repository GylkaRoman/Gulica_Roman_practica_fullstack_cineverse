<?php

namespace App\Repositories\Impl;

use App\DTO\SessionDTO;
use App\Models\MovieSession;
use App\Models\Session;
use App\Repositories\Interfaces\SessionRepositoryInterface;
use Illuminate\Support\Facades\Session as FacadesSession;

class SessionRepository implements SessionRepositoryInterface
{
    public function create(SessionDTO $dto)
    {
        return MovieSession::create([
            'movie_id' => $dto->movie_id,
            'hall_id' => $dto->hall_id,
            'date' => $dto->date,
            'time' => $dto->time,
            'format' => $dto->format,
            'language' => $dto->language,
            'base_price' => $dto->base_price,
        ]);
    }

    public function getAll(int $perPage, ?string $date = null)
    {
        $query = MovieSession::with(['movie', 'hall'])
        ->latest()
        ->cursorPaginate($perPage);

        if ($date) {
            $query = MovieSession::with(['movie', 'hall'])
            ->whereDate('date', $date)
            ->latest()
            ->cursorPaginate($perPage);
        }
        return $query;
    }

    public function getSeats(int $id)
    {
        return MovieSession::with(['hall.seats'])->findOrFail($id);
    }
}
