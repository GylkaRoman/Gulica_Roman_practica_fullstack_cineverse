<?php

namespace App\Http\Controllers\Api;

use App\DTO\Auth\LoginDTO;
use App\DTO\Auth\RegisterDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RefreshRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\Interfaces\AuthServiceInterface;
use Symfony\Component\HttpFoundation\Request;

class AuthController extends Controller
{
    public function __construct(
        private AuthServiceInterface $service
    ) {}

    public function register(RegisterRequest $request)
    {
        return $this->service->register(
            RegisterDTO::fromArray($request->validated())
        );
    }

    public function login(LoginRequest $request)
    {
        return $this->service->login(
            LoginDTO::fromArray($request->validated())
        );
    }

    public function refresh(RefreshRequest $request)
    {
        return $this->service->refresh($request->validated('refresh_token'));
    }

    public function me()
    {
        return $this->service->me();
    }

    public function logout(RefreshRequest $request)
    {
        return $this->service->logout($request->validated()['refresh_token']);
    }
}