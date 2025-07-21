<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Register - SLT</title>
  <link rel="stylesheet" href="{{ asset('css/register.css') }}" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
</head>
<body>

<div class="container">
  <div class="signup-left">
    <h2>Create Account</h2>

    <form method="POST" action="{{ route('register') }}">
      @csrf
      <input type="text" name="name" placeholder="Name" value="{{ old('name') }}" required />
      @error('name')
          <span class="error">{{ $message }}</span>
      @enderror
      
      <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required />
      @error('email')
          <span class="error">{{ $message }}</span>
      @enderror
      
      <div class="password-wrapper">
         <input type="password" id="password" name="password" placeholder="Enter your password" required>
         <span class="toggle-password"><i class="fa fa-eye"></i></span>
      </div>
      @error('password')
          <span class="error">{{ $message }}</span>
      @enderror

      <div class="password-wrapper">
        <input type="password" id="repeat_password" name="password_confirmation" placeholder="Repeat your password" required>
        <span class="toggle-password"><i class="fa fa-eye"></i></span>
      </div>

      <button type="submit" name="register">Sign Up</button>
    </form>

    <p>Already have an account? <a href="{{ route('login') }}">Sign In</a></p>
  </div>
</div>

<script src="{{ asset('js/validation.js') }}"></script>
</body>
</html>