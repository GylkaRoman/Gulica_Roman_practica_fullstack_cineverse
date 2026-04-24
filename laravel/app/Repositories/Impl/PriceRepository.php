<?php

namespace App\Repositories\Impl;

use App\Models\Price;
use App\Repositories\Interfaces\PriceRepositoryInterface;

class PriceRepository implements PriceRepositoryInterface
{
    public function getAll()
    {
        return Price::all();
    }
}
