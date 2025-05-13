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
    <!-- Navigation -->
    <header class="flex items-center justify-between px-md py-sm">
        <img src="{{asset('images/logo-maison-des-vins.png')}}" alt="Logo" class="w-[100px]">
        <nav class="off-screen-menu z-10 fixed top-0 right-[-2000px] bg-white h-screen w-full flex flex-col text-center text-lg transition-all duration-500 ease-in-out">
            <ul class="mt-[100px] min-w-full">
                <img src="{{asset('images/logo-maison-des-vins.png')}}" alt="Logo" class="w-[100px] mx-auto mb-sm">

                <li><a href="{{route('bottle.index')}}" class="text-md p-sm text-blue-magenta hover:text-taupe link-underline-hover">Catalogue des vins</a></li>
                <div class="border-t border-light-gray/50"></div>
                @if (Auth::check())
                <li><a href="{{route('logout')}}" class="text-md p-sm text-blue-magenta hover:text-taupe link-underline-hover">Se déconnecter</a></li>
                <div class="border-t border-light-gray/50"></div>
                @else
                <li><a href="{{route('login')}}" class="text-md p-sm text-blue-magenta hover:text-taupe link-underline-hover">Se connecter</a></li>
                <div class="border-t border-light-gray/50"></div>
                <li><a href="{{route('user.create')}}" class="text-md p-sm text-blue-magenta hover:text-taupe link-underline-hover">S'inscrire</a></li>
                <div class="border-t border-light-gray/50"></div>
                @endif
                @if (Auth::check())
                <li><a href="{{route('cellar.index')}}" class="text-md p-sm text-blue-magenta hover:text-taupe link-underline-hover">Mes celliers</a></li>
                <div class="border-t border-light-gray/50"></div>

                @endif
            </ul>
        </nav>

        <div class="flex items-center gap-md">
            <div class="popup bg-white h-[130px] top-[-1000px] fixed w-full">
                <input id="search" type="text" placeholder="Rechercher un vin" class="border border-light-gray/20 rounded px-2 py-2 absolute right-[70px] top-10">
                <i class="fas fa-xmark cursor-pointer absolute top-13 right-[80px] close-popup" ></i>
            </div>
            <i class="fas fa-search text-lg cursor-pointer popupIcon"></i>
            <div class="ham-menu h-[40px] w-[30px] relative cursor-pointer z-11">
                <span class="h-[2px] w-full bg-blue-magenta rounded-[25px] absolute left-1/2 top-1/5 -translate-x-1/2 transition duration-300 ease-in-out"></span>
                <span class="h-[2px] w-full bg-blue-magenta rounded-[25px] absolute left-1/2 top-2/5 -translate-x-1/2 transition duration-300 ease-in-out"></span>
                <span class="h-[2px] w-full bg-blue-magenta rounded-[25px] absolute left-1/2 top-3/5 -translate-x-1/2 transition duration-300 ease-in-out"></span>
            </div>
        </div>
    </header>

    <main class="grow m-md mb-xxl ">
        @auth
        <div class="mb-sm">Bienvenue {{ auth()->user()->name }}</div>
        @endauth
        @yield('content')
    </main>
    <footer class="hidden fixed bottom-0 w-full left-0 z-50 bg-white shadow-md ">
        <div class=" mx-auto text-md p-md">
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