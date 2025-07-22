<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Seat;
use App\Models\Reservation;
use Illuminate\Support\Facades\Log;

class SeatBookingController extends Controller
{
    public function book(Request $request)
    {
        try {
            // Validate request input
            $validated = $request->validate([
                'seat_id' => 'required|integer|exists:seats,seat_id',
                'date' => 'required|date',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        }

        $seatId = $validated['seat_id'];
        $date = $validated['date'];
        $userId = Auth::id();

        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated.'
            ], 401);
        }

        // Find the seat with correct PK
        $seat = Seat::where('seat_id', $seatId)->first();

        if (!$seat) {
            return response()->json([
                'success' => false,
                'message' => 'Seat not found.'
            ], 404);
        }

        if ($seat->status !== 'available') {
            return response()->json([
                'success' => false,
                'message' => 'Seat already booked.'
            ]);
        }

        // Check for duplicate reservation
        $existing = Reservation::where('intern_id', $userId)
            ->where('seat_id', $seatId)
            ->where('reservation_date', $date)
            ->where('status', 'active')
            ->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'You already booked this seat for this date.'
            ]);
        }

        // Mark seat as unavailable
        $seat->status = 'unavailable';
        $seat->save();

        // Create reservation
        Reservation::create([
            'intern_id' => $userId,
            'seat_id' => $seat->seat_id,
            'reservation_date' => $date,
            'time_slot' => $request->input('time_slot', 'morning'),
            'status' => 'active',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Seat booked successfully.'
        ]);
    }
}
