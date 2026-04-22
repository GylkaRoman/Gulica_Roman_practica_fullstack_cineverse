<?php

namespace App\Http\Controllers\Api;

use App\DTO\SessionDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSessionRequest;
use App\Services\Interfaces\SessionServiceInterface;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function __construct(
        private SessionServiceInterface $service
    ) {}

    public function store(StoreSessionRequest $request) {
        $dto = SessionDTO::fromArray($request->validated());

        return $this->service->create($dto);
    }

    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        
        $date = $request->query('date');

        return $this->service->getAll($perPage, $date);
    }

    public function seats(int $id)
    {
        return $this->service->getSeats($id);
    }
}
