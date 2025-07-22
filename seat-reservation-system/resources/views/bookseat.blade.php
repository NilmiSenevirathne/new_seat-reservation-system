<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Book a Seat</title>
  <link rel="stylesheet" href="{{ asset('css/bookseat.css') }}">
</head>
<body>
<div class="container">
  @include('header')
  @include('sidebar')

  <h1>Book Your Seat</h1>

  <!-- Filter Form -->
  <div class="filter-box">
    <form class="filter-form" method="GET" action="{{ route('bookseat') }}">
      <div class="form-group">
        <label for="date">Date</label>
        <input type="date" id="date" name="date"
               value="{{ old('date', $selected_date) }}"
               min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
      </div>

      <div class="form-group">
        <label for="location">Floor</label>
        <select id="location" name="location">
          <option value="">All Floors</option>
          <option value="1st Floor" {{ $selected_location == '1st Floor' ? 'selected' : '' }}>1st Floor</option>
          <option value="2nd Floor" {{ $selected_location == '2nd Floor' ? 'selected' : '' }}>2nd Floor</option>
          <option value="3rd Floor" {{ $selected_location == '3rd Floor' ? 'selected' : '' }}>3rd Floor</option>
          <option value="4th Floor" {{ $selected_location == '4th Floor' ? 'selected' : '' }}>4th Floor</option>
        </select>
      </div>

      <button type="submit">Filter Seats</button>
    </form>
  </div>

  <!-- Show all seats grouped by floor -->
  @php
    $floors = ['1st Floor', '2nd Floor', '3rd Floor', '4th Floor'];
  @endphp

  @forelse($floors as $floor)
    @php
      $floorSeats = $seats->where('location', $floor);
    @endphp

    @if ($selected_location == '' || $selected_location == $floor)
      <div class="seats-layout">
        <div class="seat-block">
          <div class="block-title">{{ $floor }}</div>
          <div class="grid">
            @foreach ($floorSeats as $seat)
              <div class="seat {{ $seat->status == 'available' ? 'available' : 'unavailable' }}"
                   data-seat-id="{{ $seat->seat_id }}"
                   data-seat-num="{{ $seat->seat_num }}">
                {{ $seat->seat_num }}
              </div>
            @endforeach
          </div>
        </div>
      </div>
    @endif

  @empty
    <div class="no-seats">
      <h3>No seats found</h3>
      <p>Please try a different floor or date.</p>
    </div>
  @endforelse
</div>

<!-- POPUP -->
<div class="overlay"></div>
<div class="popup" id="popup">
  <h2>Book Your Seat</h2>
  <p id="popup-seat"></p>
  <button id="confirm-booking" class="btn btn-ok">Confirm</button>
  <button id="close-popup" class="btn btn-close">Close</button>
</div>

<script>
  const bookingUrl = "{{ route('seat.book') }}";
  const csrfToken = "{{ csrf_token() }}";
</script>
<script src="{{ asset('js/intern_book_seats.js') }}"></script>


</body>
</html>
