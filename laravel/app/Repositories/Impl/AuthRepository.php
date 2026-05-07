<?php

namespace App\Repositories\Impl;

use App\Models\User;
use App\Repositories\Interfaces\AuthRepositoryInterface;

class AuthRepository implements AuthRepositoryInterface
{
    public function createUser(array $data)
    {
        return User::create($data);
    }
    public function findById(int $id)
    {
        return User::findOrFail($id);
    }

    public function update($user)
    {
        $user->save();
        return $user;
    }
}