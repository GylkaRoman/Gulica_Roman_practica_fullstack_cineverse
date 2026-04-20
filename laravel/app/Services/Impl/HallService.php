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

    public function create(HallDTO $dto)
    {
        return $this->repository->create($dto);
    }

    public function getAll(int $perPage)
    {
        return $this->repository->getAll($perPage);
    }
}
