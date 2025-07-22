@extends('layouts.app')

@section('content')
<div class="page-wrapper" style="display: flex;">

    <link rel="stylesheet" href="{{ asset('css/adminreserve.css') }}">

    <div class="container" style="flex-grow: 1; padding-left: 20px;">
        @include('header')
        @include('sidebar')

        <h1>Manage All Reservations</h1>

        @if(session('success_message'))
          <div class="alert alert-success">
            {{ session('success_message') }}
          </div>
        @endif

        <div class="table-wrapper">
          <table class="reservation-table">
            <thead>
              <tr>
                <th>Reservation ID</th>
                <th>Intern Name</th>
                <th>Intern Email</th>
                <th>Seat Number</th>
                <th>Location</th>
                <th>Reservation Date</th>
                <th>Time Slot</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @forelse($reservations as $reservation)
                <tr>
                  <td>{{ $reservation->reserve_id }}</td>
                  <td>{{ $reservation->intern->fname }} {{ $reservation->intern->lname }}</td>
                  <td>{{ $reservation->intern->email }}</td>
                  <td>{{ $reservation->seat->seat_num }}</td>
                  <td>{{ $reservation->seat->location }}</td>
                  <td>{{ $reservation->reservation_date }}</td>
                  <td>{{ $reservation->time_slot ?? 'N/A' }}</td>
                  <td>{{ ucfirst($reservation->status) }}</td>
                  <td>
                    <form action="{{ route('admin.reservations.destroy', $reservation->reserve_id) }}" method="POST" onsubmit="return confirm('Are you sure to cancel this reservation?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                    </form>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="9" class="text-center">No reservations found.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
    </div>
</div>
@endsection
