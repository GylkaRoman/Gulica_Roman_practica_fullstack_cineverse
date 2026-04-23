<?php

namespace App\Services\Impl;

use App\DTO\Auth\LoginDTO;
use App\DTO\Auth\RegisterDTO;
use App\Models\RefreshToken;
use App\Models\User;
use App\Services\Interfaces\AuthServiceInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PHPOpenSourceSaver\JWTAuth\JWTGuard;

class AuthService implements AuthServiceInterface
{
    private JWTGuard $auth;

    public function __construct()
    {
        $this->auth = auth('api');
    }

    public function register(RegisterDTO $dto)
    {
        $user = User::create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => Hash::make($dto->password),
            'role' => 'user',
        ]);

        $token = $this->auth->login($user);

        return $this->makeResponse($token);
    }

    public function login(LoginDTO $dto)
    {
        $credentials = [
            'email' => $dto->email,
            'password' => $dto->password,
        ];

        if (!$token = $this->auth->attempt($credentials)) {
            throw new \Exception('Unauthorized');
        }

        $user = auth('api')->user();

        $refreshToken = hash('sha256', Str::random(64));

        RefreshToken::create([
            'user_id' => $user->id,
            'token' => $refreshToken,
            'expires_at' => Carbon::now()->addDays(7),
        ]);

        return [
            'access_token' => $token,
            'refresh_token' => $refreshToken,
            'token_type' => 'bearer',
            'expires_in' => $this->auth->factory()->getTTL() * 60,
        ];
    }

    public function refresh(string $refreshToken)
    {
        $refresh = RefreshToken::where('token', $refreshToken)
            ->where('expires_at', '>', now())
            ->first();

        if (!$refresh) {
            throw new \Exception('Invalid refresh token');
        }

        $user = User::find($refresh->user_id);

        $token = $this->auth->login($user);

        return $this->makeResponse($token);
    }

    public function me()
    {
        return auth('api')->user();
    }

    public function logout(string $refreshToken)
    {
        $this->auth->logout();

        if ($refreshToken) {
            RefreshToken::where('token', $refreshToken)->delete();
        } else {
            RefreshToken::where('user_id', auth('api')->id())->delete();
        }

        return ['message' => 'Logged out'];
    }

    private function makeResponse($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->auth->factory()->getTTL() * 60,
        ];
    }
}