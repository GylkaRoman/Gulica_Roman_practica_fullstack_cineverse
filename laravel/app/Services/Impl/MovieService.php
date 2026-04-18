<?php

namespace App\Services\Impl;
use App\DTO\MovieDTO;
use App\Repositories\Interfaces\MovieRepositoryInterface;

class MovieService implements MovieRepositoryInterface
{
    public function __construct(
        private MovieRepositoryInterface $repository
    ) {}

    public function create(MovieDTO $dto)
    {
        return $this->repository->create($dto);
    }
}