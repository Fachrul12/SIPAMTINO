<!DOCTYPE html>
<html>
<head>
    <title>Aplikasi SIPAMTINO</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <nav>
        <a href="/">Home</a> |
        <a href="/logout">Logout</a>
    </nav>

    <main>
        @yield('content')
    </main>
</body>
</html>
