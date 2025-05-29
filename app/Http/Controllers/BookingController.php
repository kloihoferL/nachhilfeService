<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Offer;
use App\Models\Slot;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookingController extends Controller


{

    public function index(): JsonResponse
    {
        $bookings = Booking::with('offer')->get();
        return response()->json($bookings, 200);
    }

    public function makeBooking(Request $request)
    {

        $slot = Slot::find($request->slot_id);

        // Slot buchen
        $slot->is_booked = true;
        $slot->save();

        // Booking anlegen
        $booking = Booking::create([
            'offer_id' => $request->offer_id,
            'slot_id' => $slot->id,
            'receiver_id' => $request->receiver_id,
        ]);

        $offer = $slot->offer;

        if ($offer->slots()->where('is_booked', false)->count() === 0) {
            $offer->booked = true;
            $offer->save();
        }

        return response()->json($booking, 201);
    }

}
