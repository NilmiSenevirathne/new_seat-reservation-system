@extends('layouts.app')

@section('content')
<div class="page-wrapper" style="display: flex;">
    <link rel="stylesheet" href="{{ asset('css/report.css') }}">

    <div class="container" style="flex-grow: 1; padding-left: 20px;">
        @include('header')
        @include('sidebar')

        <h1>Reports</h1>

        <div class="report-controls">
            <form method="GET" action="{{ route('admin.reports') }}" class="period-selector">
                <h3>Select Period</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label for="month">Month:</label>
                        <select id="month" name="month" class="form-control">
                            @foreach(range(1, 12) as $m)
                                <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                    {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="year">Year:</label>
                        <select id="year" name="year" class="form-control">
                            @foreach(range(date('Y')-5, date('Y')) as $y)
                                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Generate Report</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="report-header">
            <h2>Report for: {{ date('F Y', mktime(0, 0, 0, $month, 1, $year)) }}</h2>
        </div>

        <div class="report-cards">
            <!-- Total Reservations Card -->
            <div class="report-card" onclick="window.location='{{ route('admin.reports.export', ['type' => 'total-reservations', 'month' => $month, 'year' => $year]) }}'">
                <div class="card-content">
                    <h3>Total Reservations</h3>
                    <div class="card-value">{{ $totalReservations }}</div>
                </div>
                <div class="card-footer">
                    <span class="btn-download">Download PDF</span>
                </div>
            </div>

            <!-- Most Popular Seats Card -->
            <div class="report-card" onclick="window.location='{{ route('admin.reports.export', ['type' => 'popular-seats', 'month' => $month, 'year' => $year]) }}'">
                <div class="card-content">
                    <h3>Most Popular Seat(s)</h3>
                    <div class="card-value">
                        @foreach($popularSeats as $seat)
                            {{ $seat->seat_num }}<br>
                        @endforeach
                    </div>
                    <div class="card-subtext">
                        ({{ $popularSeats->first()->reservations_count ?? 0 }} reservations each)
                    </div>
                </div>
                <div class="card-footer">
                    <span class="btn-download">Download PDF</span>
                </div>
            </div>

            <!-- Most Active Interns Card -->
            <div class="report-card" onclick="window.location='{{ route('admin.reports.export', ['type' => 'active-interns', 'month' => $month, 'year' => $year]) }}'">
                <div class="card-content">
                    <h3>Most Active Intern(s)</h3>
                    <div class="card-value">
                        @foreach($activeInterns as $intern)
                            {{ $intern->fname }} {{ $intern->lname }}<br>
                        @endforeach
                    </div>
                    <div class="card-subtext">
                        ({{ $activeInterns->first()->reservations_count ?? 0 }} reservations each)
                    </div>
                </div>
                <div class="card-footer">
                    <span class="btn-download">Download PDF</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection