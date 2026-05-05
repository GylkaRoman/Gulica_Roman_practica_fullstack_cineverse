<?php

namespace App\Http\Controllers\Api;

use App\DTO\SessionDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSessionRequest;
use App\Http\Requests\UpdateSessionRequest;
use App\Services\Interfaces\SessionServiceInterface;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function __construct(
        private SessionServiceInterface $service
    ) {}

    public function store(StoreSessionRequest $request)
    {
        return $this->service->create($request->validated());
    }
    

    public function update(UpdateSessionRequest $request, $id)
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
        $perPage = $request->query('per_page', 40);

        $date = $request->query('date');

        return $this->service->getAll($perPage, $date);
    }

    public function seats(int $id)
    {
        return $this->service->getSeats($id);
    }
}
