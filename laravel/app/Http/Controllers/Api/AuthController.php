<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\JWTGuard;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return $this->login($request);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        /** @var JWTGuard $auth */
        $auth = auth('api');

        if (!$token = $auth->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function me()
    {
        return response()->json(auth('api')->user());
    }

    public function logout()
    {
        /** @var JWTGuard $auth */
        $auth = auth('api');

        $auth->logout();

        return response()->json(['message' => 'Logged out']);
    }

    protected function respondWithToken($token)
    {
        /** @var JWTGuard $auth */
        $auth = auth('api');

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $auth->factory()->getTTL() * 60
        ]);
    }
}
