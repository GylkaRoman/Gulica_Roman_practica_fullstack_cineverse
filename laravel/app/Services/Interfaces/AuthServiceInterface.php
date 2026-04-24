<?php

namespace App\Services\Interfaces;

use App\DTO\Auth\LoginDTO;
use App\DTO\Auth\RegisterDTO;

interface AuthServiceInterface
{
    public function register(array $data);
    public function login(array $data);
    public function refresh(string $refreshToken);
    public function me();
    public function logout();
}
