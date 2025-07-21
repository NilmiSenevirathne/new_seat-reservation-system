<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seat Reservation System</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Roboto:400,700" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
</head>

<body>
    <section class="hero">
        <nav>
           <div class="logo">SEAT RESERVE</div>
                <ul>
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                    <li><a href="{{ route('login') }}">Login</a></li>
                </ul>
        </nav>
        <div class="hero-content">
            <h1> Welcome to </br> Seat Reservation System</h1>
            <p>Hello Interns !, book your seats easily and quickly.</p>
            <a href="{{ route('register') }}" class="btn">Get Started</a>
        </div>
    </section>
</body>
</html>