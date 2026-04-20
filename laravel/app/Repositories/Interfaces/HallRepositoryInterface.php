<?php

namespace App\Repositories\Interfaces;
use App\DTO\HallDTO;

interface HallRepositoryInterface
{
    public function create(HallDTO $dto);

    public function getAll(int $perPage);
}