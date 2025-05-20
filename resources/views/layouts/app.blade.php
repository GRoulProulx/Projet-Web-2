<!doctype html>
<html lang="fr" class="bg-white font-family font-light text-blue-magenta">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body class="flex flex-col min-h-[100vh]">
    <!-- Navigation -->
    <header class="flex items-center justify-between px-md py-sm">
        <h1><img src="{{asset('images/logo-maison-des-vins.png')}}" alt="Logo de l'application Maison de vins" class="w-[100px]"></h1>
        <nav class="off-screen-menu z-10 fixed top-0 right-[-10000px] bg-white h-screen w-full flex flex-col text-center text-lg transition-all duration-500 ease-in-out">
            <ul class="mt-[100px] min-w-full">
                <img src="{{asset('images/logo-maison-des-vins.png')}}" alt="Logo" class="w-[100px] mx-auto mb-sm">

                <li><a href="{{route('bottle.index')}}" class="text-md p-sm text-blue-magenta hover:text-taupe link-underline-hover"><i class="fas fa-home mr-2" aria-label="Accueil"></i>Catalogue des vins</a></li>
                <div class="border-t border-light-gray/50"></div>
                @if (Auth::check())
                <li><a href="{{route('logout')}}" class="text-md p-sm text-blue-magenta hover:text-taupe link-underline-hover"> <i class="fa-solid fa-right-from-bracket mr-2"></i>Se déconnecter</a></li>
                <div class="border-t border-light-gray/50"></div>
                <li><a href="{{ route('auth.show', auth()->user()->id) }}" class="text-md p-sm text-blue-magenta hover:text-taupe link-underline-hover"> <i class="fas fa-user mr-2
                    "></i>Mon profil</a></li>
                <div class="border-t border-light-gray/50"></div>
                @else
                <li><a href="{{route('login')}}" class="text-md p-sm text-blue-magenta hover:text-taupe link-underline-hover"><i class="fa-solid fa-right-to-bracket mr-2"></i> Se connecter</a></li>
                <div class="border-t border-light-gray/50"></div>
                <li><a href="{{route('user.create')}}" class="text-md p-sm text-blue-magenta hover:text-taupe link-underline-hover">S'inscrire</a></li>
                <div class="border-t border-light-gray/50"></div>
                @endif
                @if (Auth::check())
                <li><a href="{{route('cellar.index')}}" class="text-md p-sm text-blue-magenta hover:text-taupe link-underline-hover"> <i class="fas fa-book-open mr-2 "></i>Mes celliers</a></li>
                <div class="border-t border-light-gray/50"></div>

                @endif
            </ul>
        </nav>

        <div class="flex items-center gap-md">
            <div class="popup bg-white h-[130px] top-[-1000px] fixed w-full z-12 transition-all duration-400 ease-in-out shadow-md">
                <input id="search" type="text" placeholder="Rechercher un vin" class="border border-light-gray/20 rounded px-2 py-2 absolute right-[70px] top-10">
                <i class="fas fa-xmark cursor-pointer absolute top-13 right-[80px] close-popup"></i>
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
        @if (session('success'))
        <div class="success-message border border-light-gray/30 p-md rounded-sm mb-sm">
            <div><i class="fa-solid fa-circle-check text-gold mr-xs"></i>{{ session('success') }}</div>
        </div>
        @endif
        @if ($errors->any())
        <div class="border border-light-gray/30 p-md rounded-sm mb-sm">
            <ul>
                @foreach ($errors->all() as $error)
                <li><i class="fa-solid fa-circle-exclamation text-alert mr-xs"></i>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @yield('content')
    </main>
    <footer class="fixed bottom-0 w-full left-0 z-20 bg-white shadow-md ">
        <div class=" mx-auto text-md p-md">
            <div class="flex justify-around items-baseline gap-xs">
                <div class="flex flex-col items-center">
                    <a href="#"><i class="fas fa-home" aria-label="Accueil"></i></a>
                    <p class="text-xs">Accueil</p>
                </div>
                <div class="flex flex-col items-center">
                    <a href="{{ route('cellar.index') }}" aria-label="Mes celliers"><i class="fas fa-book-open"></i></a>
                    <p class="text-xs">Cellier</p>
                </div>
                <div class="flex flex-col items-center">
                    <a href="{{ route('bottle.index') }}" aria-label="Ajouter des bouteilles"><i class="fa-solid fa-square-plus text-xl text-gold"></i></a>
                    <p class="text-xs">Bouteilles</p>
                </div>
                @if (Auth::check())
                <div class="flex flex-col items-center">
                    <a href="{{ route('auth.show', auth()->user()->id) }}" aria-label="Mon profil"><i class="fas fa-user"></i></a>
                    <p class="text-xs">Profil</p>
                </div>
                @else
                <div class="flex flex-col items-center">
                    <a href="{{ route('login') }}" aria-label="Se connecter"><i class="fas fa-user"></i></a>
                    <p class="text-xs">Connexion</p>
                </div>
                @endif
                <div class="flex flex-col items-center">
                    <a href="#" aria-label="Rechercher"><i class="fas fa-search"></i></a>
                    <p class="text-xs">Rechercher</p>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>