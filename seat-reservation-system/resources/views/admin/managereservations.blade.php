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

        <!-- Create Button triggers new reservation modal -->
        <div style="margin-bottom: 15px;">
            <button id="openNewReservationBtn" class="btn btn-success">+ New Reservation</button>
        </div>

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
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    </select>
                </div>

                <div class="filter-group">
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                    <a href="{{ route('admin.managereservations.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </div>

        <!-- Reservation Table -->
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
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($reservations as $reservation)
                <tr>
                  <td>{{ $reservation->reserve_id }}</td>
                  <td>{{ $reservation->intern->name }}</td>
                  <td>{{ $reservation->seat->seat_num }}</td>
                  <td>{{ $reservation->seat->location }}</td>
                  <td>{{ $reservation->reservation_date }}</td>
                  <td>{{ ucfirst($reservation->status) }}</td>
                  <td>
                    <!-- Edit Button triggers modal -->
                    <button type="button" class="btn btn-warning btn-sm edit-btn" data-id="{{ $reservation->reserve_id }}">
                      Edit
                    </button>

                    <!-- Delete -->
                    <form action="{{ route('admin.managereservations.destroy', $reservation->reserve_id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this reservation?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="7" class="text-center">No reservations found.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        @if($reservations->hasPages())
          <div class="pagination-wrapper">
            {{ $reservations->appends(request()->query())->links() }}
          </div>
        @endif

    </div>
</div>

<!-- Edit Reservation Modal -->
<div class="modal" id="editReservationModal" style="display: none;">
    <div class="modal-content">
        <span class="close" id="editModalClose">&times;</span>
        <h2>Edit Reservation</h2>
        <form id="editReservationForm" method="POST">
            @csrf
            @method('PUT')

            <input type="hidden" name="reserve_id" id="edit_reserve_id">

            <div class="form-group">
                <label for="edit_status">Status:</label>
                <select name="status" id="edit_status" class="form-control">
                    <option value="active">Active</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>

            <div class="form-group">
                <label for="edit_date">Reservation Date:</label>
                <input type="date" name="reservation_date" id="edit_date" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary mt-2">Update</button>
        </form>
    </div>
</div>

<!-- New Reservation Modal -->
<div class="modal" id="newReservationModal" style="display: none;">
    <div class="modal-content">
        <span class="close" id="newModalClose">&times;</span>
        <h2>Add New Reservation</h2>
        <form id="newReservationForm" method="POST" action="{{ route('admin.managereservations.store') }}">
            @csrf

            <div class="form-group">
                <label for="new_user_id">Intern:</label>
                <select name="user_id" id="new_user_id" class="form-control" required>
                    @foreach($interns as $intern)
                        <option value="{{ $intern->id }}">{{ $intern->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="new_seat_id">Seat:</label>
                <select name="seat_id" id="new_seat_id" class="form-control" required>
                    @foreach($seats as $seat)
                        <option value="{{ $seat->id }}">{{ $seat->seat_num }} - {{ $seat->location }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="new_reservation_date">Reservation Date:</label>
                <input type="date" name="reservation_date" id="new_reservation_date" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="new_status">Status:</label>
                <select name="status" id="new_status" class="form-control" required>
                    <option value="active" selected>Active</option>
                    <option value="canceled">Canceled</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success mt-2">Create</button>
        </form>
    </div>
</div>

<script src="{{ asset('js/admin_manage_reservations.js') }}"></script>
@endsection
