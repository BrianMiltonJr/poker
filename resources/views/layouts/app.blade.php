<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="favicon.svg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <title>Poker Application</title>
</head>

<body class="bg-gradient-to-bl from-purple-400 to-zinc-500 h-screen">
    @yield('content')
    @yield('script')
</body>
</html>