<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seat;

class AdminSeatController extends Controller
{
    public function indexA()
    {
        $seats = Seat::all();
        return view('admin.manageseat', compact('seats'));
    }

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

        return redirect()->route('admin.seats')->with('success_message', 'Seat added successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'seat_num' => 'required',
            'location' => 'required'
        ]);

        $seat = Seat::findOrFail($id);
        $seat->seat_num = $request->seat_num;
        $seat->location = $request->location;
        $seat->save();

        return redirect()->route('admin.seats')->with('success_message', 'Seat updated successfully.');
    }

    public function destroy($id)
    {
        $seat = Seat::findOrFail($id);
        $seat->delete();

        return redirect()->route('admin.seats')->with('success_message', 'Seat deleted successfully.');
    }

    //get the latest seat number for that location.
     public function getNextSeatNumber($location) {
    $count = Seat::where('location', $location)->count();

    if ($count >= 50) {
        return response()->json([
            'next_seat_num' => null,
            'limit_reached' => true
        ]);
    }

    $nextNum = $count + 1;

    return response()->json([
        'next_seat_num' => $nextNum,
        'limit_reached' => false
    ]);
}

}
