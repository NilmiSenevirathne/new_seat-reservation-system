<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with(['seat', 'intern'])
            ->orderBy('reservation_date', 'desc')
            ->get();

        return view('admin.manage_reservations', compact('reservations'));
    }

    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        return redirect()->route('admin.reservations.index')
                         ->with('success_message', 'Reservation cancelled successfully!');
    }
}
