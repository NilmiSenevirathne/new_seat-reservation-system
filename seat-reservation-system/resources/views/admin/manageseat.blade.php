@extends('layouts.app')

@section('content')
<div class="admin-container">
  <div class="main-wrapper">

    @include('sidebar')
    @include('header')

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

      @if(session('success_message'))
      <div class="alert alert-success">
        {{ session('success_message') }}
      </div>
      @endif

      <section class="search-filter">
        <div class="search-box">
          <i class="fas fa-search"></i>
          <input type="text" id="searchInput" placeholder="Search seats...">
        </div>
        <div class="filter-options">
          <select id="locationFilter">
            <option value="">All Locations</option>
            <option value="1st Floor">1st Floor</option>
            <option value="2nd Floor">2nd Floor</option>
            <option value="3rd Floor">3rd Floor</option>
            <option value="4th Floor">4th Floor</option>
          </select>
        </div>
      </section>

      <section class="content-card">
        <div class="card-header">
          <h2><i class="fas fa-list"></i> All Seats</h2>
          <div class="card-actions">
            <span class="total-seats">
              <i class="fas fa-chair"></i> Total: {{ $seats->count() }} seats
            </span>
          </div>
        </div>
        <div class="table-responsive table-scroll">
          <table id="seatsTable">
  <thead>
    <tr>
      <th>Seat Number</th>
      <th>Location</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    @foreach($seats as $seat)
    <tr>
      <td>{{ $seat->seat_num }}</td>
      <td>{{ $seat->location }}</td>
      <td>
        <button onclick="openUpdateModal({{ $seat->seat_id }}, '{{ $seat->seat_num }}', '{{ $seat->location }}')" class="btn btn-sm btn-edit">
          <i class="fas fa-edit"></i> Edit
        </button>
        <form method="POST" action="{{ route('admin.seats.destroy', $seat->seat_id) }}" style="display:inline;" onsubmit="return confirm('Are you sure?')">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-sm btn-danger">
            <i class="fas fa-trash"></i> Delete
          </button>
        </form>
      </td>
    </tr>
    @endforeach

    <!-- No Results row, hidden by default -->
    <tr id="noResults" style="display:none;">
      <td colspan="3" style="text-align:center; color: red;">
        No seats found for selected filter.
      </td>
    </tr>
  </tbody>
</table>

        </div>
      </section>
    </main>
  </div>
</div>

{{-- ADD Modal --}}
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
            <label>Location</label>
            <select name="location" id="add_location" required>
              <option value="">Select Location</option>
              
              <option value="1st Floor">1st Floor</option>
              <option value="2nd Floor">2nd Floor</option>
              <option value="3rd Floor">3rd Floor</option>
              <option value="4th Floor">4th Floor</option>
            </select>
          </div>

          <div class="form-group">
            <label>Seat Number</label>
            <input type="text" id="add_seat_num" name="seat_num" required readonly>
          </div>

          <!-- ✅ Place the limit alert right under Seat Number input -->
          <div id="seatLimitAlert" style="display:none; color: red; margin-top: 10px;">
            ⚠️ You have reached the maximum limit of 50 seats for this location!
          </div>

          <div class="form-actions">
            <button type="button"   class="btn btn-cancel"  onclick="closeAddModal()">Cancel</button>
            <button type="submit" class="btn btn-add"  id="addSeatSaveBtn">Save Seat</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


{{-- UPDATE Modal --}}
<div id="updateModal" class="modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3><i class="fas fa-edit"></i> Update Seat</h3>
        <button class="close" onclick="closeUpdateModal()">&times;</button>
      </div>
      <div class="modal-body">
        <form id="updateSeatForm" method="POST">
          @csrf
          @method('PUT')
          <input type="hidden" id="update_seat_id">
          <div class="form-group">
            <label>Seat Number</label>
            <input type="text" id="update_seat_num" name="seat_num" required>
          </div>
          <div class="form-group">
            <label>Location</label>
            <select id="update_location" name="location" required>
              <option value="">Select Location</option>
              <option value="1st Floor">1st Floor</option>
              <option value="2nd Floor">2nd Floor</option>
              <option value="3rd Floor">3rd Floor</option>
              <option value="4th Floor">4th Floor</option>
            </select>
          </div>
          <div class="form-actions">
            <button type="button" onclick="closeUpdateModal()">Cancel</button>
            <button type="submit">Update Seat</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="{{ asset('js/manageseat.js') }}"></script>
@endsection
