<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;

class ReservationController extends Controller
{
    public function view()
    {
        $intern_id = Auth::id();

        $activeReservations = Reservation::with('seat')
            ->where('intern_id', $intern_id)
            ->where('status', 'active')
            ->where('reservation_date', '>=', now()->toDateString())
            ->orderBy('reservation_date', 'asc')
            ->get();

        $pastReservations = Reservation::with('seat')
            ->where('intern_id', $intern_id)
            ->where(function ($query) {
                $query->where('status', '!=', 'active')
                      ->orWhere('reservation_date', '<', now()->toDateString());
            })
            ->orderBy('reservation_date', 'desc')
            ->get();

        return view('reservations', compact('activeReservations', 'pastReservations'));
    }

    public function cancel(Request $request)
    {
        $intern_id = Auth::id();
        $reservationId = $request->input('cancel_id');

        $reservation = Reservation::where('reserve_id', $reservationId)
            ->where('intern_id', $intern_id)
            ->where('reservation_date', '>=', now()->toDateString())
            ->where('status', 'active')
            ->first();

        if ($reservation) {
            $reservation->status = 'cancelled';
            $reservation->save();

            // Mark seat as available again
            $reservation->seat->status = 'available';
            $reservation->seat->save();

            return response()->json(['success' => true]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Cancellation failed or reservation cannot be cancelled'
        ]);
    }
}

?>
