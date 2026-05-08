<?php

namespace App\Repositories\Impl;

use App\Models\RefreshToken;
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

    public function deleteRefreshTokens(int $userId)
    {
        RefreshToken::where('user_id', $userId)->delete();
    }

    public function createRefreshToken(array $data)
    {
        return RefreshToken::create($data);
    }

    public function findRefreshToken(string $token)
    {
        return RefreshToken::where('token', $token)
            ->where('expires_at', '>', now())
            ->first();
    }

    public function findUserByRefreshToken(string $token)
    {
        $refresh = $this->findRefreshToken($token);

        if (!$refresh) {
            return null;
        }

        return User::find($refresh->user_id);
    }
}