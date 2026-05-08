<?php

namespace App\Repositories\Interfaces;

interface AuthRepositoryInterface
{
    public function createUser(array $data);
    
    public function findById(int $id);
    
    public function update($user);
    
    public function deleteRefreshTokens(int $userId);

    public function createRefreshToken(array $data);

    public function findRefreshToken(string $token);

    public function findUserByRefreshToken(string $token);
}
