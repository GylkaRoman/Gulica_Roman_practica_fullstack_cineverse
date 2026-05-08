<?php

namespace Database\Seeders;

use App\Models\Price;
use Illuminate\Database\Seeder;

class PriceSeeder extends Seeder
{

    public function run(): void
    {
        $data = [
            ['type' => 'adult', 'format' => '2D', 'price' => 200],
            ['type' => 'adult', 'format' => '3D', 'price' => 250],
            ['type' => 'standard', 'format' => '2D', 'price' => 100],
            ['type' => 'standard', 'format' => '3D', 'price' => 150],
            ['type' => 'vip', 'format' => '2D', 'price' => 200],
            ['type' => 'vip', 'format' => '3D', 'price' => 250],
            ['type' => 'student', 'format' => '2D', 'price' => 70],
            ['type' => 'student', 'format' => '3D', 'price' => 120],
            ['type' => 'child', 'format' => '2D', 'price' => 50],
            ['type' => 'child', 'format' => '3D', 'price' => 70],
        ];

        foreach ($data as $item) {
            Price::create($item);
        }
    }
}
