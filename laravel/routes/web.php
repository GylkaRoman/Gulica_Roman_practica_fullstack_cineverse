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
Route::get('/price', function () {
    return Inertia::render('Price');
});
Route::get('/contact', function () {
    return Inertia::render('Contact');
});