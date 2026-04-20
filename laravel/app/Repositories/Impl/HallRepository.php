<?php

namespace App\Repositories\Impl;
use App\DTO\HallDTO;
use App\Models\Hall;
use App\Repositories\Interfaces\HallRepositoryInterface;

class HallRepository implements HallRepositoryInterface
{
    public function create(HallDTO $dto)
    {
        return Hall::create([
            'name' => $dto->name,
            'rows_count' => $dto->rows_count,
            'seats_per_row' => $dto->seats_per_row,
        ]);
    }

    public function getAll(int $perPage)
    {
        return Hall::latest()->cursorPaginate($perPage);
    }
}
