<?php

namespace App\Services\Impl;
use App\Repositories\Interfaces\MovieRepositoryInterface;
use App\Services\Interfaces\MovieServiceInterface;

class MovieService implements MovieServiceInterface
{
    public function __construct(
        private MovieRepositoryInterface $repository
    ) {}

    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    public function update(int $id, array $data)
    {
        $movie = $this->repository->findById($id);
        return $this->repository->update($movie, $data);
    }

    public function delete(int $id)
    {
        $movie = $this->repository->findById($id);
        return $this->repository->delete($movie);
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