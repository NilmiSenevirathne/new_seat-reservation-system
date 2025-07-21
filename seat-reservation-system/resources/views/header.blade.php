<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Dashboard Panel</title>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <!-- CSS -->

  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
  <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
  <link rel="stylesheet" href="{{ asset('css/header.css') }}">
</head>
<body>

<header class="topbar">
  <div class="user-info">
    <span>Welcome, {{ auth()->user() ? htmlspecialchars(auth()->user()->name) : 'Guest' }}</span>
  </div>
</header>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('.search-bar input');
    const searchIcon = document.querySelector('.search-bar i');

    if (searchIcon) {
      searchIcon.addEventListener('click', performSearch);
    }
    
    if (searchInput) {
      searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') performSearch();
      });
    }

   
  });
</script>
@endpush

</body>
</html>