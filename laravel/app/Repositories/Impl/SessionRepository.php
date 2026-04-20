<?php

namespace App\Repositories\Impl;

use App\DTO\SessionDTO;
use App\Models\Session;
use App\Repositories\Interfaces\SessionRepositoryInterface;

class SessionRepository implements SessionRepositoryInterface
{
    public function create(SessionDTO $dto)
    {
        return Session::create([
            'movie_id' => $dto->movie_id,
            'hall_id' => $dto->hall_id,
            'date' => $dto->date,
            'time' => $dto->time,
            'format' => $dto->format,
            'language' => $dto->language,
            'base_price' => $dto->base_price,
        ]);
    }

    public function getAll(int $perPage)
    {
        return Session::with(['movie', 'hall'])->latest()->cursorPaginate($perPage);
    }
}
