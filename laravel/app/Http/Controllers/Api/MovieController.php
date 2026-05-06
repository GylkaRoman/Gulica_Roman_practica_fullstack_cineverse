<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMovieRequest;
use App\DTO\MovieDTO;
use App\Http\Requests\UpdateMovieRequest;
use App\Services\Interfaces\MovieServiceInterface;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function __construct(
        private MovieServiceInterface $service
    ) {}

    public function store(StoreMovieRequest $request)
    {
        return $this->service->create($request->validated());
    }

    public function update(UpdateMovieRequest $request, $id)
    {
        return $this->service->update($id, $request->validated());
    }


    public function destroy($id)
    {
        $this->service->delete($id);
        return response()->json(['success' => true]);
    }

    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 20);
        return $this->service->getAll($perPage);
    }

    public function show(int $id)
    {
        return $this->service->getById($id);
    }
}
