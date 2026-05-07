<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
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
    public function adminIndex(Request $request)
    {
        return $this->service->adminIndex(
            $request->query('status'),
            $request->query('search')
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
    public function destroy($id)
    {
        $this->service->destroy($id);

        return response()->json(['success' => true]);
    }
}
