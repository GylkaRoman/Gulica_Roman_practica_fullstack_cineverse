<?php

namespace App\Repositories\Interfaces;

interface AuthRepositoryInterface
{
    public function createUser(array $data);
    public function findById(int $id);

    public function update($user);
}
