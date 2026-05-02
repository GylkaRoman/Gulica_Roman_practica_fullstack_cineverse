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
Route::get('/rules', function () {
    return Inertia::render('Rules');
});

Route::get('/login', fn() => Inertia::render('Login'));
Route::get('/register', fn() => Inertia::render('Register'));
Route::get('/profile', fn() => Inertia::render('Profile'));
Route::get('/admin', fn() => Inertia::render('Admin'));

Route::get('/movie/{id}', function ($id) {
    return Inertia::render('Movie');
});