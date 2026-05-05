<?php

namespace App\Repositories\Interfaces;
use App\DTO\MovieDTO;

interface MovieRepositoryInterface
{

    public function getAll(int $perPage);

    public function getById(int $id);

    public function create(array $data);
    public function findById(int $id);
    public function update($movie, array $data);
    public function delete($movie);
}