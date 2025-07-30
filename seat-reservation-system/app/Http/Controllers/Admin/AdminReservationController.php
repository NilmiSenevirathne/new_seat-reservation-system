<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\User;  // Assuming User model for interns
use App\Models\Seat;  // Assuming Seat model exists
use Illuminate\Http\Request;

class AdminReservationController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservation::with(['intern', 'seat'])
            ->orderBy('reservation_date', 'desc')
            ->orderBy('created_at', 'desc');

        if ($request->filled('date')) {
            $query->where('reservation_date', $request->date);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $reservations = $query->paginate(10);

        // Fetch interns and seats for the new reservation modal dropdown
        // Adjust the condition 'role' => 'intern' according to your user roles setup
        $interns = User::where('role', 'intern')->get();
        $seats = Seat::all();

        return view('admin.managereservations', compact('reservations', 'interns', 'seats'));
    }

    // Store new reservation from modal form
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'seat_id' => 'required|exists:seats,id',
            'reservation_date' => 'required|date',
            'status' => 'required|in:active,canceled',
        ]);

        Reservation::create([
            'user_id' => $request->user_id,
            'seat_id' => $request->seat_id,
            'reservation_date' => $request->reservation_date,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.managereservations.index')
            ->with('success_message', 'New reservation created successfully!');
    }

    // Return reservation data in JSON for edit modal form
    public function edit($id)
    {
        $reservation = Reservation::with(['intern', 'seat'])->findOrFail($id);
        return response()->json($reservation);
    }

    // Update reservation from AJAX request
   public function update(Request $request, $id)
    {
    $request->validate([
        'reservation_date' => 'required|date',
        'status' => 'required|string|in:active,cancelled',
    ]);

    $reservation = Reservation::findOrFail($id);
    $reservation->reservation_date = $request->reservation_date;
    $reservation->status = $request->status; 
    $reservation->save();

    return redirect()->route('admin.managereservations.index')
                     ->with('success_message', 'Reservation updated successfully.');}


    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        return redirect()->route('admin.managereservations.index')
                         ->with('success_message', 'Reservation cancelled successfully!');
    }
}
