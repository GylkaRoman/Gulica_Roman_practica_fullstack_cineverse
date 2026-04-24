<?php

namespace Database\Seeders;

use App\Models\Price;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['type' => 'standard', 'format' => '2D', 'price' => 100],
            ['type' => 'standard', 'format' => '3D', 'price' => 150],
            ['type' => 'vip', 'format' => '2D', 'price' => 200],
            ['type' => 'vip', 'format' => '3D', 'price' => 2500],
            ['type' => 'student', 'format' => '2D', 'price' => 70],
            ['type' => 'child', 'format' => '2D', 'price' => 50],
        ];

        foreach ($data as $item) {
            Price::create($item);
        }
    }
}
