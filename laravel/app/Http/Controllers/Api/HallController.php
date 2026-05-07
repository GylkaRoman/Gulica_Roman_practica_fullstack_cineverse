<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHallRequest;
use App\Http\Requests\UpdateHallRequest;
use App\Services\Interfaces\HallServiceInterface;
use Illuminate\Http\Request;

class HallController extends Controller
{
    public function __construct(
        private HallServiceInterface $service
    ) {}

    public function store(StoreHallRequest $request)
    {
        return $this->service->create($request->validated());
    }

    public function update(UpdateHallRequest $request, $id)
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
        $perPage = $request->query('per_page', 10);
        return $this->service->getAll($perPage);
    }
}
