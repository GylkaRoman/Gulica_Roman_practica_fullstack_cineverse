<?php

namespace App\Repositories\Interfaces;

interface SessionRepositoryInterface
{

    public function getAll(int $perPage, ?string $date = null);

    public function getSeats(int $id);

    public function create(array $data);

    public function findById(int $id);

    public function update($session, array $data);

    public function delete($session);
}
