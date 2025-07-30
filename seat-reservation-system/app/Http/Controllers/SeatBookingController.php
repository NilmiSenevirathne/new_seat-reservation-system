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
            'time_slot' => 'required|string|in:08:30-10:30,08:30-12:30,08:30-16:30',

        ]);

        $seatId = $validated['seat_id'];
        $date = $validated['date'];
        $timeSlot = $validated['time_slot'];
        $userId = Auth::id();

        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'You must be logged in to book a seat.'
            ], 401);
        }

        $today = Carbon::today();
        $selectedDate = Carbon::parse($date);

        if ($selectedDate->isPast()) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot book a seat for a past date.'
            ]);
        }

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

        // Check if intern already has a booking for the same date and time slot
        $hasOtherBooking = Reservation::where('intern_id', $userId)
            ->where('reservation_date', $date)
            ->where('time_slot', $timeSlot)
            ->where('status', 'active')
            ->exists();

        if ($hasOtherBooking) {
            return response()->json([
                'success' => false,
                'message' => 'You have already reserved a seat for this time slot on this day.'
            ]);
        }

        // Check if seat is already booked for the same date and time slot
        $isBooked = Reservation::where('seat_id', $seatId)
            ->where('reservation_date', $date)
            ->where('time_slot', $timeSlot)
            ->where('status', 'active')
            ->exists();

        if ($isBooked) {
            return response()->json([
                'success' => false,
                'message' => 'This seat is already booked for that date and time slot.'
            ]);
        }

        Reservation::create([
            'intern_id' => $userId,
            'seat_id' => $seatId,
            'reservation_date' => $date,
            'time_slot' => $timeSlot,
            'status' => 'active',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Seat booked successfully!'
        ]);
    }
}
