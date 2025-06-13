<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mood Music</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>
    <div class="wrapper">
        <img src="{{ asset('images/logo.png') }}" alt="logo" class="logo">
        @if ($errors->any())
            <div class="alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="/register">
            @csrf
            <input type="text" class="{{ $errors->has('username') ? 'input-error' : '' }}" name="username"
                placeholder="Username" value="{{ old('username') }}" required>
            <input type="email" class="{{ $errors->has('email') ? 'input-error' : '' }}" name="email"
                placeholder="Email" value="{{ old('email') }}" required>
            <input type="password" class="{{ $errors->has('password') ? 'input-error' : '' }}" name="password"
                placeholder="Password" required>
            <input type="password" class="{{ $errors->has('password') ? 'input-error' : '' }}"
                name="password_confirmation" placeholder="Confirm Password" required>
            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="/login" class="link">Sign in</a></p>
    </div>
</body>

</html>
