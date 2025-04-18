<!doctype html>
<html lang="fr" class="bg-white font-family font-light m-md">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title')</title>
    @vite('resources/css/app.css')
</head>

<body>
    <nav>Navigation à faire</nav>
    <main>
        @yield('content')
    </main>
    <footer>Footer à faire</footer>
</body>

</html>