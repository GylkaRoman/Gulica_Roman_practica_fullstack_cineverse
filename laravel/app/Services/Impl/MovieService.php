<?php

namespace App\Services\Impl;
use App\DTO\MovieDTO;
use App\Repositories\Interfaces\MovieRepositoryInterface;
use App\Services\Interfaces\MovieServiceInterface;

class MovieService implements MovieServiceInterface
{
    public function __construct(
        private MovieRepositoryInterface $repository
    ) {}

    public function create(MovieDTO $dto)
    {
        return $this->repository->create($dto);
    }

    public function getAll(int $perPage)
    {
        return $this->repository->getAll($perPage);
    }

    public function getById(int $id)
    {
        return $this->repository->getById($id);
    }
}