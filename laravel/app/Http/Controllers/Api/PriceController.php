<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\PriceServiceInterface;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    public function __construct(
        private PriceServiceInterface $service
    ) {}

    public function index()
    {
        return response()->json(
            $this->service->getAll()
        );
    }
}
