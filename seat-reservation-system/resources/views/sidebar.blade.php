@php
    $role = auth()->user()->role ?? 'guest';
    $sidebars = [
        'admin' => [
            ["route" => "dashboard", "icon" => "fas fa-home", "text" => "Dashboard"],
            ["route" => "admin.seats.index", "icon" => "fas fa-users-cog", "text" => "Manage Seats"],
            ["route" => "admin.reservations.index", "icon" => "fas fa-calendar-check", "text" => "Reservations"],
            ["route" => "reports.index", "icon" => "fas fa-chart-line", "text" => "Reports"],
            ["route" => "logout", "icon" => "fas fa-sign-out-alt", "text" => "Logout"],
        ],
        'intern' => [
            ["route" => "dashboard", "icon" => "fas fa-home", "text" => "Dashboard"],
            ["route" => "bookseat", "icon" => "fas fa-chair", "text" => "Book Seats"],
            ["route" => "reservations", "icon" => "fas fa-calendar-alt", "text" => "My Reservations"],
            ["route" => "logout", "icon" => "fas fa-sign-out-alt", "text" => "Logout"],
        ],
    ];
    $links = $sidebars[$role] ?? [];
@endphp

<!-- Toggle Button (Mobile Only) -->
<button class="sidebar-toggle" id="sidebarToggle">
    <i class="fas fa-bars"></i>
</button>

<!-- Sidebar Navigation -->
<nav class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <h3>Seat Reservation System</h3>
        
    </div>
    
    <ul class="sidebar-menu">
        @foreach($links as $link)
            <li class="menu-item {{ request()->routeIs($link['route']) ? 'active' : '' }}">
                <a href="{{ route($link['route']) }}" class="menu-link">
                    <i class="{{ $link['icon'] }} menu-icon"></i>
                    <span class="menu-text">{{ $link['text'] }}</span>
                </a>
            </li>
        @endforeach
    </ul>
</nav>

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/sidebar.js') }}"></script>
@endpush