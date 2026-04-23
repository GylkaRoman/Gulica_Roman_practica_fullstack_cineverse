<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RefreshToken;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PHPOpenSourceSaver\JWTAuth\JWTGuard;

class AuthController extends Controller
{
    private JWTGuard $auth;

    public function __construct()
    {
        $this->auth = auth('api');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        $token = $this->auth->login($user);

        return $this->respondWithToken($token);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = $this->auth->attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = $this->auth->user();

        $refreshToken = hash('sha256', Str::random(64));

        RefreshToken::create([
            'user_id' => $user->id,
            'token' => $refreshToken,
            'expires_at' => Carbon::now()->addDays(7),
        ]);

        return response()->json([
            'access_token' => $token,
            'refresh_token' => $refreshToken,
            'token_type' => 'bearer',
            'expires_in' => $this->auth->factory()->getTTL() * 60,
        ]);
    }

    public function refresh(Request $request)
    {
        $request->validate([
            'refresh_token' => 'required'
        ]);

        $refresh = RefreshToken::where('token', $request->refresh_token)
            ->where('expires_at', '>', now())
            ->first();

        if (!$refresh) {
            return response()->json(['error' => 'Invalid refresh token'], 401);
        }

        $user = User::find($refresh->user_id);

        $newToken = $this->auth->login($user);

        return response()->json([
            'access_token' => $newToken,
            'token_type' => 'bearer',
            'expires_in' => $this->auth->factory()->getTTL() * 60,
        ]);
    }

    public function me()
    {
        return response()->json($this->auth->user());
    }

    public function logout(Request $request)
    {
        $this->auth->logout();

        if ($request->refresh_token) {
            RefreshToken::where('token', $request->refresh_token)->delete();
        } else {
            RefreshToken::where('user_id', $this->auth->id())->delete();
        }

        return response()->json([
            'message' => 'Logged out'
        ]);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->auth->factory()->getTTL() * 60,
        ]);
    }
}