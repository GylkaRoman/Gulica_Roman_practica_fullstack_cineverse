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

    public function store(Request $request)
    {
        return $this->service->create($request->all());
    }

    public function update(Request $request, $id)
    {
        return $this->service->update($id, $request->all());
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
