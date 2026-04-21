<?php

namespace Database\Seeders;

use App\Models\Hall;
use App\Models\Movie;
use App\Models\MovieSession;
use App\Models\Session;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SessionSeeder extends Seeder
{
    public function run(): void
    {
        $movies = Movie::pluck('id');
    $halls = Hall::pluck('id');

    $dates = [
        Carbon::now()->toDateString(),
        Carbon::now()->addDay()->toDateString(),
        Carbon::now()->addDays(2)->toDateString(),
        Carbon::now()->addDays(3)->toDateString(),
        Carbon::now()->addDays(4)->toDateString(),
        Carbon::now()->addDays(5)->toDateString(),
        Carbon::now()->addDays(6)->toDateString(),
    ];

    MovieSession::insert([

        ['movie_id' => $movies[0], 'hall_id' => $halls[0], 'date' => $dates[0], 'time' => '10:00', 'format' => '2D', 'language' => 'ru', 'base_price' => 100],
        ['movie_id' => $movies[1], 'hall_id' => $halls[1], 'date' => $dates[0], 'time' => '14:00', 'format' => '3D', 'language' => 'en', 'base_price' => 120],
        ['movie_id' => $movies[2], 'hall_id' => $halls[2], 'date' => $dates[0], 'time' => '18:00', 'format' => '2D', 'language' => 'ro', 'base_price' => 140],

        ['movie_id' => $movies[3], 'hall_id' => $halls[0], 'date' => $dates[1], 'time' => '10:00', 'format' => '2D', 'language' => 'ru', 'base_price' => 100],
        ['movie_id' => $movies[4], 'hall_id' => $halls[1], 'date' => $dates[1], 'time' => '14:00', 'format' => '3D', 'language' => 'en', 'base_price' => 120],
        ['movie_id' => $movies[5], 'hall_id' => $halls[2], 'date' => $dates[1], 'time' => '18:00', 'format' => '2D', 'language' => 'ro', 'base_price' => 140],

        ['movie_id' => $movies[6], 'hall_id' => $halls[0], 'date' => $dates[2], 'time' => '10:00', 'format' => '2D', 'language' => 'ru', 'base_price' => 100],
        ['movie_id' => $movies[7], 'hall_id' => $halls[1], 'date' => $dates[2], 'time' => '14:00', 'format' => '3D', 'language' => 'en', 'base_price' => 120],
        ['movie_id' => $movies[8], 'hall_id' => $halls[2], 'date' => $dates[2], 'time' => '18:00', 'format' => '2D', 'language' => 'ro', 'base_price' => 140],

        ['movie_id' => $movies[9], 'hall_id' => $halls[0], 'date' => $dates[3], 'time' => '10:00', 'format' => '2D', 'language' => 'ru', 'base_price' => 100],
        ['movie_id' => $movies[0], 'hall_id' => $halls[1], 'date' => $dates[3], 'time' => '14:00', 'format' => '3D', 'language' => 'en', 'base_price' => 120],
        ['movie_id' => $movies[1], 'hall_id' => $halls[2], 'date' => $dates[3], 'time' => '18:00', 'format' => '2D', 'language' => 'ro', 'base_price' => 140],

        ['movie_id' => $movies[2], 'hall_id' => $halls[0], 'date' => $dates[4], 'time' => '10:00', 'format' => '2D', 'language' => 'ru', 'base_price' => 100],
        ['movie_id' => $movies[3], 'hall_id' => $halls[1], 'date' => $dates[4], 'time' => '14:00', 'format' => '3D', 'language' => 'en', 'base_price' => 120],
        ['movie_id' => $movies[4], 'hall_id' => $halls[2], 'date' => $dates[4], 'time' => '18:00', 'format' => '2D', 'language' => 'ro', 'base_price' => 140],

        ['movie_id' => $movies[5], 'hall_id' => $halls[0], 'date' => $dates[5], 'time' => '10:00', 'format' => '2D', 'language' => 'ru', 'base_price' => 100],
        ['movie_id' => $movies[6], 'hall_id' => $halls[1], 'date' => $dates[5], 'time' => '14:00', 'format' => '3D', 'language' => 'en', 'base_price' => 120],
        ['movie_id' => $movies[7], 'hall_id' => $halls[2], 'date' => $dates[5], 'time' => '18:00', 'format' => '2D', 'language' => 'ro', 'base_price' => 140],
        
        ['movie_id' => $movies[8], 'hall_id' => $halls[0], 'date' => $dates[6], 'time' => '10:00', 'format' => '2D', 'language' => 'ru', 'base_price' => 100],
        ['movie_id' => $movies[9], 'hall_id' => $halls[1], 'date' => $dates[6], 'time' => '14:00', 'format' => '3D', 'language' => 'en', 'base_price' => 120],
        ['movie_id' => $movies[0], 'hall_id' => $halls[2], 'date' => $dates[6], 'time' => '18:00', 'format' => '2D', 'language' => 'ro', 'base_price' => 140],
    ]);   
    }
}
