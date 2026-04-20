<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MovieController;

Route::post('/movies', [MovieController::class, 'store']);

Route::get('/movies', [MovieController::class, 'index']);