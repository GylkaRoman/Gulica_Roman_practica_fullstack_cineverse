<?php

namespace App\Services\Interfaces;

use App\DTO\Auth\LoginDTO;
use App\DTO\Auth\RegisterDTO;

interface AuthServiceInterface
{
    public function register(RegisterDTO $dto);
    public function login(LoginDTO $dto);
    public function refresh(string $refreshToken);
    public function me();
    public function logout(string $refreshToken);
}
