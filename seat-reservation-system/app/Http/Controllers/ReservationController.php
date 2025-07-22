<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;

class ReservationController extends Controller
{
    /**
     * Display the reservations page.
     */
    public function view()
    {
        $user = Auth::user();
        $intern_id = $user->user_id;

        // Get active reservations (future and status active)
        $activeReservations = Reservation::with('seat')
            ->where('intern_id', $intern_id)
            ->where('status', 'active')
            ->where('reservation_date', '>=', now()->toDateString())
            ->orderBy('reservation_date', 'asc')
            ->get();

        // Get past reservations (cancelled or past date)
        $pastReservations = Reservation::with('seat')
            ->where('intern_id', $intern_id)
            ->where(function ($query) {
                $query->where('status', '!=', 'active')
                      ->orWhere('reservation_date', '<', now()->toDateString());
            })
            ->orderBy('reservation_date', 'desc')
            ->get();

        // Return the reservations view (resources/views/reservations.blade.php)
        return view('reservations', compact('activeReservations', 'pastReservations'));
    }

    /**
     * Cancel a reservation via AJAX.
     */
    public function cancel(Request $request)
    {
        $user = Auth::user();
        $intern_id = $user->user_id;

        $reservationId = $request->input('cancel_id');

        $reservation = Reservation::where('reserve_id', $reservationId)
            ->where('intern_id', $intern_id)
            ->where('reservation_date', '>=', now()->toDateString())
            ->where('status', 'active')
            ->first();

        if ($reservation) {
            $reservation->status = 'cancelled';
            $reservation->save();

            return response()->json(['success' => true]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Cancellation failed or reservation cannot be cancelled'
        ]);
    }

    

    
}
