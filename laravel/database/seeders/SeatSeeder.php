<?php

namespace Database\Seeders;

use App\Models\Hall;
use App\Models\Seat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeatSeeder extends Seeder
{
    public function run(): void
    {
        $halls = Hall::all();

        $data = [];

        foreach ($halls as $hall) {
            for ($row = 1; $row <= $hall->rows_count; $row++) {
                for ($seat = 1; $seat <= $hall->seats_per_row; $seat++) {

                    $data[] = [
                        'hall_id' => $hall->id,
                        'row_number' => $row,
                        'seat_number' => $seat,
                        'type' => $row === 1 ? 'vip' : 'standard',
                    ];
                }
            }
        }

        Seat::insert($data);
    }
}
