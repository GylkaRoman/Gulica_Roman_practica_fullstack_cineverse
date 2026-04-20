<?php

use App\Http\Controllers\Api\HallController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MovieController;

Route::post('/movies', [MovieController::class, 'store']);

Route::get('/movies', [MovieController::class, 'index']);

Route::get('/movies/{id}', [MovieController::class, 'show']);

Route::post('/halls', [HallController::class, 'store']);

Route::get('/halls', [HallController::class, 'index']);