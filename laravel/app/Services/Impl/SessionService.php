<?php

namespace App\Services\Impl;

use App\DTO\SessionDTO;
use App\Repositories\Interfaces\SessionRepositoryInterface;
use App\Services\Interfaces\SessionServiceInterface;

class SessionService implements SessionServiceInterface
{
    public function __construct(
        private SessionRepositoryInterface $repository
    ) {}

    public function create(SessionDTO $dto)
    {
        return $this->repository->create($dto);
    }

    public function getAll(int $perPage, ?string $date = null)
    {
        return $this->repository->getAll($perPage, $date);
    }
}
