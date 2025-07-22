<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class AdminReservationController extends Controller
{
    public function index(Request $request)
{
    $query = Reservation::with(['intern', 'seat'])
                ->orderBy('reservation_date', 'desc')
                ->orderBy('created_at', 'desc');

    if ($request->has('date') && $request->date != '') {
        $query->where('reservation_date', $request->date);
    }

    if ($request->has('status') && $request->status != '') {
        $query->where('status', $request->status);
    }

    if ($request->filled('date')) {
        $query->where('reservation_date', $request->date);
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }


    $reservations = $query->paginate(10);

    return view('admin.managereservations', compact('reservations'));
}

    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        return redirect()->route('admin.managereservations.index')
                         ->with('success_message', 'Reservation cancelled successfully!');
    }
}
