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

    public function register(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'user',
        ]);

        $this->auth->login($user);
    }

    public function login(array $data)
    {
        if (!$token = $this->auth->attempt($data)) {
            throw new \Exception('Unauthorized');
        }

        $user = auth('api')->user();

        RefreshToken::where('user_id', $user->id)->delete();

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

        $user = User::find($refresh->user_id);;

        $accessToken = $this->auth->login($user);

        return [
            'access_token' => $accessToken,
            'refresh_token' => $refresh['token'],
            'token_type' => 'bearer',
            'expires_in' => $this->auth->factory()->getTTL() * 60,
        ];
    }

    public function me()
    {
        return $this->auth->user();
    }

    public function logout()
    {

        $user = $this->auth->user();

        RefreshToken::where('user_id', $user->id)->delete();

        $this->auth->logout();

        return response()->json(['message' => 'Logged out']);
    
    }
}
