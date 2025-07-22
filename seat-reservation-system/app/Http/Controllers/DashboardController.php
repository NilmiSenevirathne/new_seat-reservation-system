<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Seat;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            // Admin: Show system-wide stats
            $totalReservations = Reservation::count();
            $totalUsers = User::count();
            $totalSeats = Seat::count();

            return view('dashboard', compact(
                'totalReservations',
                'totalUsers',
                'totalSeats'
            ));
        } elseif (Auth::user()->role === 'intern') {
            // Intern: Show only their own stats
            $myReservations = Reservation::where('intern_id', Auth::id())->count();
            $upcomingReservations = Reservation::where('intern_id', Auth::id())
                ->where('reservation_date', '>=', now()->toDateString())
                ->count();
            $availableSeats = Seat::where('status', 'available')->count();

            return view('dashboard', compact(
                'myReservations',
                'upcomingReservations',
                'availableSeats'
            ));
        }

        // Optional fallback: if someone has a role not covered
        return redirect()->route('login')->with('error', 'Unauthorized');
    }
}
