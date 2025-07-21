<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Login - SLT</title>
  <link rel="stylesheet" href="{{ asset('css/register.css') }}" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
</head>
<body>

<div class="container">
  <div class="login-left">
    <h2>Sign In</h2>

    <form method="POST" action="{{ route('login') }}">
      @csrf
      
      <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required />
      @error('email')
          <span class="error">{{ $message }}</span>
      @enderror
      
      <div class="password-wrapper">
        <input type="password" id="login_password" name="password" placeholder="Enter your password" required>
        <span class="toggle-password"><i class="fa fa-eye"></i></span>
      </div>
      @error('password')
          <span class="error">{{ $message }}</span>
      @enderror
      
      <button type="submit" name="login">Sign In</button>
    </form>

    <p>Don't have an account? <a href="{{ route('register') }}">Sign Up</a></p>
  </div>
</div>

<script src="{{ asset('js/validation.js') }}"></script>
</body>
</html>