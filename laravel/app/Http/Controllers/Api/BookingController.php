<?php

namespace App\Http\Controllers\Api;

use App\DTO\BookingDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Services\Impl\BookingService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function __construct(
        private BookingService $service
    ) {}

    public function store(StoreBookingRequest $request)
    {
        $dto = BookingDTO::fromArray(
            $request->validated(),
            $request->user()->id
        );

        return $this->service->create($dto);
    }

    public function index()
    {
        return $this->service->getUserBookings(auth()->id);
    }

    public function pay($id)
{
    try {
        $booking = $this->service->pay($id, auth()->id);

        return response()->json($booking);

    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage()
        ], 400);
    }
}
}
