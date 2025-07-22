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

        <div class="filter-box">
            <form class="filter-form" method="GET" action="{{ route('bookseat') }}">
                <div class="form-group">
                    <label for="date">Date</label>
                    <input type="date" id="date" name="date"
                           value="{{ old('date', $selected_date) }}"
                           min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                </div>

                <div class="form-group">
                    <label for="location">Location</label>
                    <select id="location" name="location">
                        <option value="">All Locations</option>
                        <option value="Window Side" {{ $selected_location == 'Window Side' ? 'selected' : '' }}>Window Side</option>
                        <option value="Middle" {{ $selected_location == 'Middle' ? 'selected' : '' }}>Middle</option>
                        <option value="Front" {{ $selected_location == 'Front' ? 'selected' : '' }}>Front</option>
                        <option value="Back" {{ $selected_location == 'Back' ? 'selected' : '' }}>Back</option>
                    </select>
                </div>

                <button type="submit">Filter Seats</button>
            </form>
        </div>

        <div class="seats-container">
            @if(count($seats) > 0)
                @foreach ($seats as $seat)
                    <div class="seat-card">
                        <div class="seat-number">Seat {{ $seat->seat_num }}</div>
                        <div class="seat-location">{{ $seat->location }}</div>
                        <div class="seat-date">{{ $selected_date }}</div>
                        <a href="#"
                           class="book-btn"
                           data-seat-id="{{ $seat->id }}"
                           data-date="{{ $selected_date }}">
                           Book This Seat
                        </a>
                    </div>
                @endforeach
            @else
                <div class="no-seats">
                    <h3>No available seats found</h3>
                    <p>Please try a different date or location</p>
                </div>
            @endif
        </div>
    </div>

    <script src="{{ asset('js/intern_book_seats.js') }}"></script>
</body>
</html>
