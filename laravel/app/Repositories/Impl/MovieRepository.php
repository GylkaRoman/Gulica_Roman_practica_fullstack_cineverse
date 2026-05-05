<?php

namespace App\Repositories\Impl;
use App\DTO\MovieDTO;
use App\Models\Movie;
use App\Repositories\Interfaces\MovieRepositoryInterface;

class MovieRepository implements MovieRepositoryInterface
{
    public function create(array $data)
    {
        return \App\Models\Movie::create($data);
    }

    public function findById(int $id)
    {
        return \App\Models\Movie::findOrFail($id);
    }

    public function update($movie, array $data)
    {
        $movie->update($data);
        return $movie;
    }

    public function delete($movie)
    {
        return $movie->delete();
    }

    public function getAll(int $perPage)
    {
        return Movie::latest()->cursorPaginate($perPage);
    }

    public function getById(int $id)
    {
        return Movie::findOrFail($id);
    }
}