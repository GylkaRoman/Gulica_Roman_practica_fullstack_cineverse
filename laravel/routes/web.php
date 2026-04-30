<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
});
Route::get('/main', function () {
    return Inertia::render('Home');
});
Route::get('/program', function () {
    return Inertia::render('Program');
});