<?php

namespace App\Services\Interfaces;

interface AuthServiceInterface
{
    public function register(array $data);
    public function login(array $data);
    public function refresh(string $refreshToken);
    public function me(int $userId);
    public function update(int $userId, array $data);
    public function logout();
}
