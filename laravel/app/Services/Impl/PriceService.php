<?php

namespace App\Services\Impl;

use App\Repositories\Interfaces\PriceRepositoryInterface;
use App\Services\Interfaces\PriceServiceInterface;

class PriceService implements PriceServiceInterface
{
    public function __construct(
        private PriceRepositoryInterface $repository
    ) {}

    public function getAll()
    {
        return $this->repository->getAll();
    }
}
