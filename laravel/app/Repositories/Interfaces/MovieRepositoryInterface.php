<?php

namespace App\Repositories\Interfaces;
use App\DTO\MovieDTO;

interface MovieRepositoryInterface
{
    public function create(MovieDTO $dto);

    public function getAll(int $perPage);

}