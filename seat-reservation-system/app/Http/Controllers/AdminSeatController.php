<?php

namespace App\Http\Controllers;

use App\Models\Seat;
use Illuminate\Http\Request;

class AdminSeatController extends Controller
{
    // Show all seats
    public function index()
    {
        $seats = Seat::orderBy('seat_id', 'DESC')->get();
        return view('admin.manageseat', compact('seats'));
    }

    // Store new seat
    public function store(Request $request)
    {
        $request->validate([
            'seat_num' => 'required',
            'location' => 'required'
        ]);

        Seat::create([
            'seat_num' => $request->seat_num,
            'location' => $request->location
        ]);

        return redirect()->back()->with('success', 'Seat added successfully!');
    }

    // Update seat
    public function update(Request $request, $id)
    {
        $request->validate([
            'seat_num' => 'required',
            'location' => 'required'
        ]);

        $seat = Seat::findOrFail($id);
        $seat->update([
            'seat_num' => $request->seat_num,
            'location' => $request->location
        ]);

        return redirect()->back()->with('success', 'Seat updated successfully!');
    }

    // Delete seat
    public function destroy($id)
    {
        Seat::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Seat deleted successfully!');
    }
}
