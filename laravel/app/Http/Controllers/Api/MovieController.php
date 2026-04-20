<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMovieRequest;
use App\DTO\MovieDTO;
use App\Services\Interfaces\MovieServiceInterface;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function __construct(
        private MovieServiceInterface $service
    ) {}

    public function store(StoreMovieRequest $request) {
        $dto = MovieDTO::fromArray($request->validated());

        return $this->service->create($dto);
    }

    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        return $this->service->getAll($perPage);

    }
}
