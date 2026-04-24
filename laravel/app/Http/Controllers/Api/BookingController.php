<?php

namespace App\Http\Controllers\Api;

use App\DTO\BookingDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Services\Impl\BookingService;
use App\Services\Interfaces\BookingServiceInterface;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function __construct(
        private BookingServiceInterface $service
    ) {}

    public function store(StoreBookingRequest $request)
    {
        return $this->service->create(
            $request->validated(),
            $request->user()->id,
        );
    }

    public function index(Request $request)
    {
        return $this->service->getUserBookings($request->user()->id);
    }

    public function pay(int $id, Request $request)
    {
        try {
            $booking = $this->service->pay($id, $request->user()->id);

            return response()->json($booking);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
