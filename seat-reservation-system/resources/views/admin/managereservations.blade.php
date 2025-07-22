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

        <!-- Filter Form -->
        <div class="filter-container" style="margin-bottom: 20px;">
            <form method="GET" action="{{ route('admin.managereservations.index') }}" class="filter-form">
                <div class="filter-row">
                    <div class="filter-group">
                        <label for="date">Filter by Date:</label>
                        <input type="date" id="date" name="date" value="{{ request('date') }}" class="form-control">
                    </div>
                    
                    <div class="filter-group">
                        <label for="status">Filter by Status:</label>
                        <select id="status" name="status" class="form-control">
                            <option value="">All Statuses</option>
                            <option value="canceled" {{ request('status') == 'canceled' ? 'selected' : '' }}>Canceled</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <button type="submit" class="btn btn-primary">Apply Filters</button>
                        <a href="{{ route('admin.managereservations.index') }}" class="btn btn-secondary">Reset Filters</a>
                    </div>
                </div>
            </form>
        </div>

        <div class="table-wrapper">
          <table class="reservation-table">
            <thead>
              <tr>
                <th>Reservation ID</th>
                <th>Intern Name</th>
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
                  <td>{{ $reservation->seat->seat_num }}</td>
                  <td>{{ $reservation->seat->location }}</td>
                  <td>{{ $reservation->reservation_date }}</td>
                  <td>{{ $reservation->time_slot ?? 'N/A' }}</td>
                  <td>{{ ucfirst($reservation->status) }}</td>
                  <td>
                    @if($reservation->status == 'reserved')
                    <form action="{{ route('admin.reservations.destroy', $reservation->reserve_id) }}" method="POST" onsubmit="return confirm('Are you sure to cancel this reservation?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                    </form>
                    @else
                    <span class="text-muted">No action</span>
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="9" class="text-center">No reservations found.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
          
          <!-- Pagination Links -->
          @if($reservations->hasPages())
          <div class="pagination-wrapper">
              {{ $reservations->appends(request()->query())->links() }}
          </div>
          @endif
        </div>
    </div>
</div>

<style>
    .filter-container {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        margin-top: 20px;
    }
    
    .filter-form {
        display: flex;
        flex-direction: column;
    }
    
    .filter-row {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        align-items: flex-end;
    }
    
    .filter-group {
        display: flex;
        flex-direction: column;
        min-width: 200px;
    }
    
    .filter-group label {
        margin-bottom: 5px;
        font-weight: 500;
    }
    
    .pagination-wrapper {
        margin-top: 20px;
        display: flex;
        justify-content: center;
    }
    
    .pagination-wrapper .pagination {
        flex-wrap: wrap;
    }
</style>
@endsection