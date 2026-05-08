<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {

        $this->call([
            MovieSeeder::class,
            HallSeeder::class,
            SeatSeeder::class,
            SessionSeeder::class,
            PriceSeeder::class,
            AdminUserSeeder::class,
        ]);
    }
}
