@extends('layouts.app')

@section('content')
<div class="page-wrapper" style="display: flex; flex-direction: row;">

    <link rel="stylesheet" href="{{ asset('css/adminreserve.css') }}">

    <div class="container" style="flex-grow: 1; padding-left: 20px;">
        @include('header')
        @include('sidebar')

        <h1>Manage All Reservations</h1>

        @if(session('success_message'))
          <div class="success-msg">
            {{ session('success_message') }}
          </div>
        @endif

        <!-- Filter Form -->
        <div class="filter-container">
            <form method="GET" action="{{ route('admin.managereservations.index') }}" class="filter-form">
  <div class="filter-group">
    <label for="date">Filter by Date:</label>
    <input type="date" id="date" name="date" value="{{ request('date') }}">
  </div>

  <div class="filter-group">
    <label for="status">Filter by Status:</label>
    <select id="status" name="status">
      <option value="">All Statuses</option>
      <option value="canceled" {{ request('status') == 'canceled' ? 'selected' : '' }}>Canceled</option>
      <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
    </select>
  </div>

  <div class="filter-group">
    <button type="submit" class="btn btn-primary">Apply Filters</button>
    <a href="{{ route('admin.managereservations.index') }}" class="btn btn-secondary">Reset</a>
  </div>
</form>

        </div>

        <div class="table-wrapper">
          <table class="reservation-table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Intern</th>
                <th>Seat</th>
                <th>Location</th>
                <th>Date</th>
                <th>Status</th>
                
              </tr>
            </thead>
            <tbody>
              @forelse($reservations as $reservation)
                <tr>
                  <td>{{ $reservation->reserve_id }}</td>
                  <td>{{ $reservation->intern->fname }} {{ $reservation->intern->lname }}</td>
                  <td>{{ $reservation->seat->seat_num }}</td>
                  <td>{{ $reservation->seat->location }}</td>
                  <td>{{ $reservation->reservation_date }}</td>
                  <td>{{ ucfirst($reservation->status) }}</td>
                  <!-- <td>
                    @if($reservation->status == 'reserved')
                    <form action="{{ route('admin.reservations.destroy', $reservation->reserve_id) }}" method="POST" onsubmit="return confirm('Cancel this reservation?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                    </form>
                    @else
                    <span class="text-muted">No action</span>
                    @endif
                  </td> -->
                </tr>
              @empty
                <tr>
                  <td colspan="8" class="text-center">No reservations found.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        @if($reservations->hasPages())
          <div class="pagination-wrapper">
            {{ $reservations->appends(request()->query())->links() }}
          </div>
        @endif

    </div>
</div>
@endsection
