<?php

namespace App\Repositories\Impl;
use App\Models\Hall;
use App\Repositories\Interfaces\HallRepositoryInterface;

class HallRepository implements HallRepositoryInterface
{
    public function create(array $data)
    {
        return Hall::create($data);
    }

    public function findById(int $id)
    {
        return Hall::findOrFail($id);
    }

    public function update(Hall $hall, array $data)
    {
        $hall->update($data);
        return $hall;
    }

    public function delete(Hall $hall)
    {
        return $hall->delete();
    }

    public function getAll(int $perPage)
    {
        return Hall::latest()->cursorPaginate($perPage);
    }
}
