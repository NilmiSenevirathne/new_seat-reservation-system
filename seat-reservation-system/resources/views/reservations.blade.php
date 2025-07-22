@extends('layouts.app')

@section('content')
<div class="page-wrapper" style="display: flex;">

    {{-- Style sheet --}}
    <link rel="stylesheet" href="{{ asset('css/reservations.css') }}">

    {{-- Main content area --}}
    <div class="container" style="flex-grow: 1; padding-left: 20px;">
        @include('header')
        @include('sidebar')
        <h1>My Reservations</h1>

        <div class="reservations-wrapper-vertical">
            <div class="reservation-section">
                <h2>Active Reservations</h2>
            <div class="table-wrapper" >
                <table id="active-reservations" class="reservation-table">
                    <thead>
                        <tr>
                            <th>Seat Number</th>
                            <th>Location</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($activeReservations as $reservation)
                        <tr data-reservation-id="{{ $reservation->reserve_id }}">
                            <td>{{ $reservation->seat->seat_num }}</td>
                            <td>{{ $reservation->seat->location }}</td>
                            <td>{{ $reservation->reservation_date }}</td>
                            <td class="status">{{ ucfirst($reservation->status) }}</td>
                            <td>
                                <a href="#"
                                   class="cancel-btn"
                                   data-reservation-id="{{ $reservation->reserve_id }}"
                                >Cancel</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center">You have no active reservations.</td></tr>
                    @endforelse
                    </tbody>
                </table>
             </div>
            </div>

            <div class="reservation-section">
                <h2>Past Reservations</h2>
                <table id="past-reservations" class="reservation-table">
                    <thead>
                        <tr>
                            <th>Seat Number</th>
                            <th>Location</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($pastReservations as $reservation)
                        <tr>
                            <td>{{ $reservation->seat->seat_num }}</td>
                            <td>{{ $reservation->seat->location }}</td>
                            <td>{{ $reservation->reservation_date }}</td>
                            <td>{{ ucfirst($reservation->status) }}</td>
                            <td>N/A</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center">You have no past reservations.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    const cancelUrl = "{{ route('reservations.cancel') }}";
    const csrfToken = "{{ csrf_token() }}";
</script>

<script src="{{ asset('js/reservations.js') }}"></script>
@endsection
