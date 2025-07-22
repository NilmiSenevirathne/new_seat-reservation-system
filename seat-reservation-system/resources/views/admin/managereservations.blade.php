@extends('layouts.app')

@section('content')
@include('sidebar')

<div class="admin-container">
  <div class="main-wrapper">
    <main class="main-content">
      <header class="main-header">
        <h1>Manage Reservations</h1>
      </header>

      @if(session('success_message'))
      <div class="alert alert-success">
        {{ session('success_message') }}
      </div>
      @endif

      <section class="content-card">
        <div class="card-header">
          <h2><i class="fas fa-calendar-check"></i> All Reservations</h2>
          <div class="card-actions">
            <span class="total-reservations">
              <i class="fas fa-chair"></i> Total: {{ $reservations->count() }} reservations
            </span>
          </div>
        </div>

        <div class="table-responsive">
          <table>
            <thead>
              <tr>
                <th>ID</th>
                <th>Intern</th>
                <th>Seat</th>
                <th>Location</th>
                <th>Date</th>
                <th>Time Slot</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($reservations as $reservation)
              <tr>
                <td>{{ $reservation->reserve_id }}</td>
                <td>{{ $reservation->intern->name }}</td>
                <td>{{ $reservation->seat->seat_num }}</td>
                <td>{{ $reservation->seat->location }}</td>
                <td>{{ $reservation->reservation_date }}</td>
                <td>{{ $reservation->time_slot }}</td>
                <td>{{ $reservation->status }}</td>
                <td>
                  <form method="POST" action="{{ route('admin.reservations.destroy', $reservation->reserve_id) }}" onsubmit="return confirm('Cancel this reservation?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Cancel</button>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

      </section>
    </main>
  </div>
</div>
@endsection
