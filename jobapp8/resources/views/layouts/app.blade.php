<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Job App' }}</title>
    @if (Request::is('employer*'))
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @endif
</head>
<body @if (Request::is('employer*')) style="background:#f8f9fa; color:#222;" @endif>
    <nav class="nav">
        <div class="container nav__inner">
            <a href="{{ url('/') }}" class="brand">JobApp</a>
            <div class="nav__links">
                @auth
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn--link">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn--link">Login</a>
                    <a href="{{ route('register') }}" class="btn btn--primary">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    @if (Request::is('employer*'))
        {{-- Employers: wider layout, matches dashboard --}}
        <main style="max-width:1200px; margin:0 auto; padding:2rem 0;">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @yield('content')
        </main>
    @else
        <main class="container">
            @if ($errors->any())
                <div class="alert alert--error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @yield('content')
        </main>
    @endif
</body>
</html>


