<?php

namespace App\Services\Impl;
use App\DTO\HallDTO;
use App\Repositories\Interfaces\HallRepositoryInterface;
use App\Services\Interfaces\HallServiceInterface;

class HallService implements HallServiceInterface
{
    public function __construct(
        private HallRepositoryInterface $repository
    ) {}

    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    public function update(int $id, array $data)
    {
        $hall = $this->repository->findById($id);
        return $this->repository->update($hall, $data);
    }

    public function delete(int $id)
    {
        $hall = $this->repository->findById($id);
        return $this->repository->delete($hall);
    }

    public function getAll(int $perPage)
    {
        return $this->repository->getAll($perPage);
    }
}
