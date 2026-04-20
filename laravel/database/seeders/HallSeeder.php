<?php

namespace Database\Seeders;

use App\Models\Hall;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HallSeeder extends Seeder
{

    public function run(): void
    {
        Hall::insert([
            [
                'name' => 'Hall 1',
                'rows_count' => 5,
                'seats_per_row' => 5,
            ],
            [
                'name' => 'Hall 2',
                'rows_count' => 6,
                'seats_per_row' => 6,
            ],
            [
                'name' => 'Hall 3',
                'rows_count' => 7,
                'seats_per_row' => 7,
            ],
        ]);
    }
}
