<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MovieController;

Route::get('/', function () {
    return view('user/main');
});

Route::post('/movies', [MovieController::class, 'store']);