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

        $seats = Seat::whereDoesntHave('reservations', function ($query) use ($selected_date) {
            $query->where('reservation_date', $selected_date)
                  ->where('status', 'active');
        });

        if (!empty($selected_location)) {
            $seats->where('location', $selected_location);
        }

        $seats = $seats->get();

        return view('bookseat', [
            'seats' => $seats,
            'selected_date' => $selected_date,
            'selected_location' => $selected_location,
        ]);
    }
}
