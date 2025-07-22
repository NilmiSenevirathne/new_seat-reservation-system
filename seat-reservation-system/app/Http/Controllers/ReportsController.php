<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Seat;
use App\Models\User; // Changed from Intern to User
use PDF;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));
        
        // Total Reservations
        $totalReservations = Reservation::whereMonth('reservation_date', $month)
            ->whereYear('reservation_date', $year)
            ->count();
        
        // Most Popular Seats
        $popularSeats = Seat::withCount(['reservations' => function($q) use ($month, $year) {
                $q->whereMonth('reservation_date', $month)
                  ->whereYear('reservation_date', $year);
            }])
            ->orderBy('reservations_count', 'desc')
            ->take(3)
            ->get();
        
        // Most Active Interns (now using User model)
        $activeInterns = User::where('role', 'intern') // Filter for interns only
            ->withCount(['reservations' => function($q) use ($month, $year) {
                $q->whereMonth('reservation_date', $month)
                  ->whereYear('reservation_date', $year);
            }])
            ->orderBy('reservations_count', 'desc')
            ->take(3)
            ->get();
        
        return view('admin.reports', compact(
            'month', 
            'year', 
            'totalReservations', 
            'popularSeats', 
            'activeInterns'
        ));
    }

    public function export(Request $request)
    {
        $type = $request->input('type');
        $month = $request->input('month');
        $year = $request->input('year');
        
        $data = [
            'month' => $month,
            'year' => $year,
            'title' => ucwords(str_replace('-', ' ', $type)) . ' Report',
            'date' => date('F Y', mktime(0, 0, 0, $month, 1, $year))
        ];
        
        switch($type) {
            case 'total-reservations':
                $data['count'] = Reservation::whereMonth('reservation_date', $month)
                    ->whereYear('reservation_date', $year)
                    ->count();
                break;
                
            case 'popular-seats':
                $data['seats'] = Seat::withCount(['reservations' => function($q) use ($month, $year) {
                        $q->whereMonth('reservation_date', $month)
                          ->whereYear('reservation_date', $year);
                    }])
                    ->orderBy('reservations_count', 'desc')
                    ->take(5)
                    ->get();
                break;
                
            case 'active-interns':
                $data['intern'] = User::where('role', 'intern') // Filter for interns only
                    ->withCount(['reservations' => function($q) use ($month, $year) {
                        $q->whereMonth('reservation_date', $month)
                          ->whereYear('reservation_date', $year);
                    }])
                    ->orderBy('reservations_count', 'desc')
                    ->take(5)
                    ->get();
                break;
        }
        
        $pdf = PDF::loadView("admin.reports.{$type}", $data);
        return $pdf->download("{$type}-report-{$month}-{$year}.pdf");
    }
}