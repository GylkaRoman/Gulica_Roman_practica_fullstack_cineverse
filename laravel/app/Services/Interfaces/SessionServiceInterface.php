<?php

namespace App\Services\Interfaces;

use App\DTO\SessionDTO;

interface SessionServiceInterface
{

    public function getAll(int $perPage, ?string $date = null);

    public function getSeats(int $id);

    public function create(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);
}
