<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seat;

class InternSeatController extends Controller
{
    public function show(Request $request)
    {
        $selected_date = $request->query('date', now()->format('Y-m-d'));
        $selected_location = $request->query('location', '');
        $selected_time_slot = $request->query('time_slot', ''); // New time slot param

        $seats = Seat::whereDoesntHave('reservations', function ($query) use ($selected_date, $selected_time_slot) {
            $query->where('reservation_date', $selected_date)
                  ->where('status', 'active');

            if (!empty($selected_time_slot)) {
                $query->where('time_slot', $selected_time_slot);
            }
        });

        if (!empty($selected_location)) {
            $seats->where('location', $selected_location);
        }

        $seats = $seats->get();

        return view('bookseat', [
            'seats' => $seats,
            'selected_date' => $selected_date,
            'selected_location' => $selected_location,
            'selected_time_slot' => $selected_time_slot,
        ]);
    }
}
