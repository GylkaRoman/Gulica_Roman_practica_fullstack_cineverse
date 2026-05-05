<?php

namespace App\Services\Interfaces;
use App\DTO\HallDTO;

interface HallServiceInterface
{

    public function getAll(int $perPage);

    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}
