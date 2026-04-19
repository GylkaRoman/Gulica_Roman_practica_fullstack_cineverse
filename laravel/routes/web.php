<?php

use App\Http\Controllers\Api\MovieController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('user/main');
});

Route::post('/movies', [MovieController::class, 'store']);