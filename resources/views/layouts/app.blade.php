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
    <header class="flex items-center justify-between p-md">
        <div class="off-screen-menu z-10 fixed top-0 left-[-500px] bg-white h-screen w-full max-w-[500px] flex flex-col items-center justify-center text-center text-lg transition-all duration-500 ease-in-out">
            <ul>
                <li><a href="#" class="hover:text-taupe">Accueil</a></li>
                <li><a href="{{route('bottle.index')}}" class="hover:text-taupe">Catalogue des vins</a></li>
                <li><a href="{{route('login')}}" class="hover:text-taupe">Se connecter</a></li>
                <li><a href="{{route('user.create')}}" class="hover:text-taupe">S'inscrire</a></li>
                @if (Auth::check())
                <li><a href="{{route('cellar.index')}}" class="hover:text-taupe">Mes celliers</a></li>
                @endif
            </ul>
        </div>

        <nav class="flex">
            <div class="ham-menu h-[50px] w-[30px] relative cursor-pointer z-11">
                <span class="h-[3px] w-full bg-blue-magenta rounded-[25px] absolute left-1/2 top-1/5 -translate-x-1/2 transition duration-300 ease-in-out"></span>
                <span class="h-[3px] w-full bg-blue-magenta rounded-[25px] absolute left-1/2 top-2/5 -translate-x-1/2 transition duration-300 ease-in-out"></span>
                <span class="h-[3px] w-full bg-blue-magenta rounded-[25px] absolute left-1/2 top-3/5 -translate-x-1/2 transition duration-300 ease-in-out"></span>
            </div>
        </nav>
        <h1 class="font-title text-center text-lg text-transparent bg-clip-text bg-gradient-to-b from-black via-gray-500 to-gray-100">MAISON DES VINS</h1>
        <i class="fas fa-search text-lg"></i>
    </header>
    <main class="grow m-md mb-xxl">
        @yield('content')
    </main>
    <footer class="fixed bottom-0 w-full left-0 z-50 bg-white shadow-md ">
        <div class="  mx-auto text-md p-md  ">
            <div class="flex justify-around items-center">
                <a href="{{ route('cellar.index') }}"><i class="fas fa-home"></i></a>
                <a href="{{ route('bottle.index') }}"><i class="fas fa-book-open"></i></a>
                <i class="fas fa-user"></i>
                <i class="fas fa-search"></i>
            </div>
        </div>
    </footer>
</body>

</html>