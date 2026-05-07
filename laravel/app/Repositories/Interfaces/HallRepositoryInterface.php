<?php

namespace App\Repositories\Interfaces;
use App\Models\Hall;

interface HallRepositoryInterface
{

    public function getAll(int $perPage);

    public function create(array $data);
    public function findById(int $id);
    public function update(Hall $hall, array $data);
    public function delete(Hall $hall);
    
}