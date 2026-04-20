<?php

namespace App\Http\Controllers\Api;

use App\DTO\HallDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHallRequest;
use App\Services\Interfaces\HallServiceInterface;
use Illuminate\Http\Request;

class HallController extends Controller
{
    public function __construct(
        private HallServiceInterface $service
    ) {}

    public function store(StoreHallRequest $request) {
        $dto = HallDTO::fromArray($request->validated());

        return $this->service->create($dto);
    }

    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        return $this->service->getAll($perPage);
    }
}
