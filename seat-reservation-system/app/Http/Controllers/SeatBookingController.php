<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Seat;
use App\Models\Reservation;
use Carbon\Carbon;

class SeatBookingController extends Controller
{
    public function book(Request $request)
    {
        $validated = $request->validate([
            'seat_id' => 'required|integer|exists:seats,seat_id',
            'date' => 'required|date',
        ]);

        $seatId = $validated['seat_id'];
        $date = $validated['date'];
        $userId = Auth::id();

        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'You must be logged in to book a seat.'
            ], 401);
        }

        $today = Carbon::today();
        $selectedDate = Carbon::parse($date);

        // ✅ 1. Past dates cannot be booked
        if ($selectedDate->isPast()) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot book a seat for a past date.'
            ]);
        }

        // ✅ 2. Must book at least 1 hour in advance if booking for today
        if ($selectedDate->isSameDay($today)) {
            $now = Carbon::now();
            if ($now->diffInMinutes($selectedDate->copy()->endOfDay()) < 60) {
                return response()->json([
                    'success' => false,
                    'message' => 'You must book at least 1 hour in advance.'
                ]);
            }
        }

        $seat = Seat::find($seatId);
        if (!$seat) {
            return response()->json([
                'success' => false,
                'message' => 'Seat not found.'
            ], 404);
        }

        // ✅ 3. Intern can only reserve one seat per day
        $hasOtherBooking = Reservation::where('intern_id', $userId)
            ->where('reservation_date', $date)
            ->where('status', 'active')
            ->exists();

        if ($hasOtherBooking) {
            return response()->json([
                'success' => false,
                'message' => 'You have already reserved a seat for this day.'
            ]);
        }

        // ✅ 4. Seat cannot be reserved if already booked for that date
        $isBooked = Reservation::where('seat_id', $seatId)
            ->where('reservation_date', $date)
            ->where('status', 'active')
            ->exists();

        if ($isBooked) {
            return response()->json([
                'success' => false,
                'message' => 'This seat is already booked for that date.'
            ]);
        }

        // ✅ All clear → create reservation
        Reservation::create([
            'intern_id' => $userId,
            'seat_id' => $seatId,
            'reservation_date' => $date,
            'time_slot' => $request->input('time_slot', 'morning'),
            'status' => 'active',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Seat booked successfully!'
        ]);
    }
}
