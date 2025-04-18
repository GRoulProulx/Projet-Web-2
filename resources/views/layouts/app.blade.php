<!doctype html>
<html lang="fr" class="bg-white font-family font-light m-md">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite('resources/css/app.css')
</head>

<body>
    <header class="flex justify-between items-center mb-8">
        <i class="fas fa-bars "></i>
        <h1 class="font-title text-center">MAISON DES VINS</h1>
        <i class="fas fa-search "></i>
    </header>
    <main>
        @yield('content')
    </main>
    <footer class="">
        <div class="container mx-auto max-w-md">
            <div class="flex justify-around">
                <i class="fas fa-home"></i>
                <i class="fas fa-book-open"></i>
                <i class="fas fa-user"></i>
                <i class="fas fa-search"></i>
            </div>
        </div>
    </footer>
</body>

</html>