<?php

namespace App\Repositories\Impl;
use App\DTO\MovieDTO;
use App\Models\Movie;
use App\Repositories\Interfaces\MovieRepositoryInterface;

class MovieRepository implements MovieRepositoryInterface
{
    public function create(MovieDTO $dto)
    {
        return Movie::create([
            'title' => $dto->title,
            'original_title' => $dto->original_title,
            'description' => $dto->description,
            'poster_url' => $dto->poster_url,
            'trailer_url' => $dto->trailer_url,
            'genre' => $dto->genre,
            'duration' => $dto->duration,
            'age_rating' => $dto->age_rating,
            'director' => $dto->director,
            'actors' => $dto->actors,
        ]);
    }

    public function getAll(int $perPage)
    {
        return Movie::latest()->paginate($perPage);
    }

    public function getById(int $id)
    {
        return Movie::findOrFail($id);
    }
}