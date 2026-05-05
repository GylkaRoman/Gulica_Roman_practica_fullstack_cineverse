<?php

use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\HallController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\SessionController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PriceController;

Route::get('/movies', [MovieController::class, 'index']);
Route::get('/movies/{id}', [MovieController::class, 'show']);
Route::get('/halls', [HallController::class, 'index']);
Route::get('/sessions', [SessionController::class, 'index']);
Route::get('/sessions/{id}/seats', [SessionController::class, 'seats']);

Route::get('/prices', [PriceController::class, 'index']);

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
});
Route::delete('/bookings/{id}', [BookingController::class, 'destroy']);

Route::middleware('auth:api')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/bookings', [BookingController::class, 'store']);
    Route::get('/user/bookings', [BookingController::class, 'index']);
    Route::post('/bookings/{id}/pay', [BookingController::class, 'pay']);
    Route::get('/profile', [AuthController::class, 'me']);

    Route::delete('/bookings/{id}', [BookingController::class, 'destroy']);
});

Route::middleware(['auth:api', 'role:admin'])->group(function () {

    Route::post('/movies', [MovieController::class, 'store']);
    Route::put('/movies/{id}', [MovieController::class, 'update']);
    Route::delete('/movies/{id}', [MovieController::class, 'destroy']);

    Route::post('/halls', [HallController::class, 'store']);
    Route::put('/halls/{id}', [HallController::class, 'update']);
    Route::delete('/halls/{id}', [HallController::class, 'destroy']);

    Route::post('/sessions', [SessionController::class, 'store']);
    Route::put('/sessions/{id}', [SessionController::class, 'update']);
    Route::delete('/sessions/{id}', [SessionController::class, 'destroy']);

    Route::get('/admin/bookings', [BookingController::class, 'adminIndex']);
});