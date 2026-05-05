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
        $perPage = $request->query('per_page', 10);
        return $this->service->getAll($perPage);
    }
}
