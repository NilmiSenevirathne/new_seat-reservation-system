<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Dashboard Panel</title>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- Your CSS -->
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>

@include('sidebar')
@include('header')

<main class="main-content" id="content">
  @auth
    @if(auth()->user()->role === 'admin')
      <!-- ADMIN DASHBOARD -->
      <div class="stats-cards">
        <div class="card traffic">
          <h5>Total Reservations</h5>
          <h3>{{ $totalReservations }}</h3>
        </div>
        <div class="card traffic-small">
          <h5>Total Users</h5>
          <h3>{{ $totalUsers }}</h3>
        </div>
        <div class="card sales">
          <h5>Total Seats</h5>
          <h3>{{ $totalSeats }}</h3>
        </div>
      </div>

    @elseif(auth()->user()->role === 'intern')
      <!-- INTERN DASHBOARD -->
      <div class="stats-cards">
        <div class="card traffic">
          <h5>My Total Reservations</h5>
          <h3>{{ $myReservations }}</h3>
        </div>
        <div class="card traffic-small">
          <h5>Upcoming Reservation</h5>
          <h3>{{ $upcomingReservations }}</h3>
        </div>
        <div class="card sales">
          <h5>Seats Available</h5>
          <h3>{{ $availableSeats }}</h3>
        </div>
        
      </div>
    @endif
  @else
    <!-- GUEST VIEW -->
    <p>Unauthorized. Please <a href="{{ route('login') }}">login</a>.</p>
  @endauth
</main>

<script>
  // If you have Chart.js data to plot, do it here.
</script>

</body>
</html>
