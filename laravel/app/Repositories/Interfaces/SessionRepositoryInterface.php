<?php

namespace App\Repositories\Interfaces;
use App\DTO\SessionDTO;

interface SessionRepositoryInterface
{
    public function create(SessionDTO $dto);

    public function getAll(int $perPage, ?string $date = null);

    public function getSeats(int $id);
}
