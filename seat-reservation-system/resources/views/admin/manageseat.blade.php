@extends('layouts.app')

@section('content')

<div class="admin-container">
  <div class="main-wrapper">

    {{-- Include sidebar --}}
    @include('sidebar')
    @include('header')

     {{--style sheet --}}
    <link rel="stylesheet" href="{{ asset('css/manageseat.css') }}">

    <main class="main-content">
      <header class="main-header">
        <h1>Seat Management</h1>
        <div class="header-actions">
          <button id="openAddModal" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Seat
          </button>
        </div>
      </header>

      {{-- Success Message --}}
      @if(session('success_message'))
      <div class="alert alert-success">
        {{ session('success_message') }}
      </div>
      @endif

      {{-- Search and Filter --}}
      <section class="search-filter">
        <div class="search-box">
          <i class="fas fa-search"></i>
          <input type="text" id="searchInput" placeholder="Search seats...">
        </div>
        <div class="filter-options">
          <select id="locationFilter">
            <option value="">All Locations</option>
            <option value="Window Side">Window Side</option>
            <option value="Middle">Middle</option>
            <option value="Front">Front</option>
            <option value="Back">Back</option>
          </select>
        </div>
      </section>

      {{-- Seats Table --}}
      <section class="content-card">
        <div class="card-header">
          <h2><i class="fas fa-list"></i> All Seats</h2>
          <div class="card-actions">
            <span class="total-seats">
              <i class="fas fa-chair"></i> Total: {{ $seats->count() }} seats
            </span>
          </div>
        </div>
        <div class="table-responsive">
          <table id="seatsTable">
            <thead>
              <tr>
                <th>ID</th>
                <th>Seat Number</th>
                <th>Location</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($seats as $seat)
              <tr>
                <td>{{ $seat->seat_id }}</td>
                <td><span class="seat-badge">{{ $seat->seat_num }}</span></td>
                <td>{{ $seat->location }}</td>
                <td><span class="status-badge available">Available</span></td>
                <td class="action-buttons">
                  <button class="btn btn-sm btn-edit" 
                    onclick="openUpdateModal({{ $seat->seat_id }}, '{{ $seat->seat_num }}', '{{ $seat->location }}')">
                    <i class="fas fa-edit"></i> Edit
                  </button>

                  <form method="POST" action="{{ route('admin.seats.destroy', $seat->seat_id) }}" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this seat?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">
                      <i class="fas fa-trash"></i> Delete
                    </button>
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

{{-- Add Seat Modal --}}
<div id="addModal" class="modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3><i class="fas fa-plus-circle"></i> Add New Seat</h3>
        <button class="close" onclick="closeAddModal()">&times;</button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('admin.seats.store') }}">
          @csrf
          <div class="form-group">
            <label for="location"><i class="fas fa-map-marker-alt"></i> Location</label>
            <select id="location" name="location" required>
              <option value="">Select Location</option>
              <option value="Window Side">Window Side</option>
              <option value="Middle">Middle</option>
              <option value="Front">Front</option>
              <option value="Back">Back</option>
            </select>
          </div>
          <div class="form-group">
            <label for="seat_num"><i class="fas fa-hashtag"></i> Seat Number</label>
            <input type="text" id="seat_num" name="seat_num" placeholder="e.g., A1, B2, etc." required>
            <span id="seat_num_loading" style="display:none;"><i class="fas fa-spinner fa-spin"></i></span>
          </div>
          <div class="form-actions">
            <button type="button" class="btn btn-secondary" onclick="closeAddModal()">Cancel</button>
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-save"></i> Save Seat
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

{{-- Update Seat Modal --}}
<div id="updateModal" class="modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3><i class="fas fa-edit"></i> Update Seat</h3>
        <button class="close" onclick="closeUpdateModal()">&times;</button>
      </div>
      <div class="modal-body">
        <form method="POST" id="updateSeatForm">
          @csrf
          @method('PUT')
          <input type="hidden" name="seat_id" id="update_seat_id">
          <div class="form-group">
            <label for="update_seat_num"><i class="fas fa-hashtag"></i> Seat Number</label>
            <input type="text" id="update_seat_num" name="seat_num" required>
          </div>
          <div class="form-group">
            <label for="update_location"><i class="fas fa-map-marker-alt"></i> Location</label>
            <select id="update_location" name="location" required>
              <option value="Window Side">Window Side</option>
              <option value="Middle">Middle</option>
              <option value="Front">Front</option>
              <option value="Back">Back</option>
            </select>
          </div>
          <div class="form-actions">
            <button type="button" class="btn btn-secondary" onclick="closeUpdateModal()">Cancel</button>
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-save"></i> Update Seat
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="../js/manageseat.js"></script>


@endsection
