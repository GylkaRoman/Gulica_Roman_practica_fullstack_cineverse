<?php

namespace App\Services\Interfaces;
use App\DTO\HallDTO;

interface HallServiceInterface
{
    public function create(HallDTO $dto);

    public function getAll(int $perPage);
}
