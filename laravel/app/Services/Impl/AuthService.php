<?php

namespace App\Services\Impl;

use App\Repositories\Interfaces\AuthRepositoryInterface;
use App\Services\Interfaces\AuthServiceInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PHPOpenSourceSaver\JWTAuth\JWTGuard;

class AuthService implements AuthServiceInterface
{
    private JWTGuard $auth;

    public function __construct(
        private AuthRepositoryInterface $repo,
    ) {
        $this->auth = auth('api');
    }

    public function register(array $data)
    {
        $user = $this->repo->createUser([
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
            return response()->json([
                'message' => 'Invalid email or password'
            ], 401);
        }

        $user = $this->auth->user();

        $this->repo->deleteRefreshTokens($user->id);

        $refreshToken = hash('sha256', Str::random(64));

        $this->repo->createRefreshToken([
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
        $refresh = $this->repo->findRefreshToken($refreshToken);

        if (!$refresh) {
            return response()->json([
                'message' => 'Invalid refresh token'
            ], 401);
        }

        $user = $this->repo->findById($refresh->user_id);

        $accessToken = $this->auth->login($user);

        return [
            'access_token' => $accessToken,
            'refresh_token' => $refresh['token'],
            'token_type' => 'bearer',
            'expires_in' => $this->auth->factory()->getTTL() * 60,
        ];
    }

    public function me(int $userId)
    {
        return $this->repo->findById($userId);
    }

    public function update(int $userId, array $data)
    {
        $user = $this->repo->findById($userId);

        $user->name = $data['name'];
        $user->email = $data['email'];

        if (!empty($data['new_password'])) {

            if (!Hash::check($data['old_password'], $user->password)) {
                throw new Exception('Old password is incorrect');
            }

            $user->password = Hash::make($data['new_password']);
        }

        return $this->repo->update($user);
    }

    public function logout()
    {
        $user = $this->auth->user();

        $this->repo->deleteRefreshTokens($user->id);

        $this->auth->logout();

        return response()->json([
            'message' => 'Logged out'
        ]);
    }
}
