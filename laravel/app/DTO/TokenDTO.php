<?php

namespace App\DTO\Auth;

class TokenDTO
{
    public function __construct(
        public string $accessToken,
        public ?string $refreshToken,
        public int $expiresIn
    ) {}
}
