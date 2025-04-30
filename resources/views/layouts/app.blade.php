<!doctype html>
<html lang="fr" class="bg-white font-family font-light text-blue-magenta">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body class="flex flex-col min-h-[100vh]">
    <header class=" flex justify-between items-center mb-8 text-md m-md">
        <i class="fas fa-bars "></i>
        <h1 class="font-title text-center text-lg text-transparent bg-clip-text bg-gradient-to-b from-black via-gray-500 to-gray-100">MAISON DES VINS</h1>

        <i class="fas fa-search "></i>
    </header>
    <main class="grow m-md">
        @yield('content')
    </main>
    <footer>
        <div class="mx-auto text-md p-md">
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