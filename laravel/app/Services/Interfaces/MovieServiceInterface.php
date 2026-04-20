<?php

namespace App\Services\Interfaces;

use App\DTO\MovieDTO;

interface MovieServiceInterface
{
    public function create(MovieDTO $dto);

    public function getAll(int $perPage);

    public function getById(int $id);
}
