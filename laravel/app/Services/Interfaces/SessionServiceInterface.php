<?php

namespace App\Services\Interfaces;

use App\DTO\SessionDTO;

interface SessionServiceInterface
{
    public function create(SessionDTO $dto);

    public function getAll(int $perPage);
}
