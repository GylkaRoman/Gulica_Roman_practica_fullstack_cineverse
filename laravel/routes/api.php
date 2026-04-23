<?php

use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\HallController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\SessionController;
use App\Http\Controllers\Api\AuthController;

Route::get('/movies', [MovieController::class, 'index']);
Route::get('/movies/{id}', [MovieController::class, 'show']);
Route::get('/halls', [HallController::class, 'index']);
Route::get('/sessions', [SessionController::class, 'index']);
Route::get('/sessions/{id}/seats', [SessionController::class, 'seats']);

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth:api')->group(function () {

    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/bookings', [BookingController::class, 'store']);
    Route::get('/user/bookings', [BookingController::class, 'index']);
    Route::post('/bookings/{id}/pay', [BookingController::class, 'pay']);
});

Route::middleware(['auth:api', 'role:admin'])->group(function () {
    Route::post('/movies', [MovieController::class, 'store']);
    Route::post('/halls', [HallController::class, 'store']);
});