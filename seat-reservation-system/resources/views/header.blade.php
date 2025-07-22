<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Dashboard Panel</title>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
  <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
  <link rel="stylesheet" href="{{ asset('css/header.css') }}">

  <style>
    .user-info {
      position: relative;
      cursor: pointer;
    }

    .dropdown-menu {
      position: absolute;
      top: 100%;
      right: 0;
      display: none; /* hidden by default */
      flex-direction: column;
      background: white;
      border: 1px solid #ccc;
      box-shadow: 0 2px 5px rgba(0,0,0,0.15);
      z-index: 1000;
      min-width: 150px;
    }

    .dropdown-menu a,
    .dropdown-menu button {
      padding: 10px 15px;
      color: #333;
      text-decoration: none;
      background: white;
    }

    .dropdown-menu a:hover,
    .dropdown-menu button:hover {
      background: #f2f2f2;
    }

    .user-name i {
      margin-left: 5px;
    }
  </style>
</head>
<body>

<header class="topbar">
  <div class="left-header">
    <!-- Toggle button or logo if needed -->
  </div>

  <div class="user-info">
    <div class="user-name">
      {{ auth()->user() ? e(auth()->user()->name) : 'Guest' }}
      <i class="fas fa-caret-down"></i>
    </div>
    <div class="dropdown-menu" id="userDropdown">
      <a href="{{ route('profile.edit') }}">Profile</a>
      
      <form id="logout-form" action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
      </form>
    </div>
  </div>
</header>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const userInfo = document.querySelector('.user-info');
    const dropdown = document.getElementById('userDropdown');

    userInfo.addEventListener('click', function(e) {
      e.stopPropagation();
      dropdown.style.display = dropdown.style.display === 'flex' ? 'none' : 'flex';
    });

    // Hide when clicking outside
    document.addEventListener('click', function() {
      dropdown.style.display = 'none';
    });
  });
</script>

</body>
</html>
