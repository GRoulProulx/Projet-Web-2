@extends('layouts.app')
@section('title', 'Connexion')

@section('content')

<!-- Page de Connexion -->

<!-- Test de la connexion TODO: À enlever  après les tests-->
<div class="p-md mb-4 bg-gray-300 rounded-sm">
    @auth
    <h1>Bienvenue, {{ auth()->user()->name }}</h1>
    <p>Authentifié avec succès!</p>
    @else
    <p>Non authentifié. Veuillez vous connecter.</p>
    @endauth
</div>
<!-- Fin du test de la connexion -->


<div class="border border-light-gray/30 p-md rounded-sm">
    <div>
        <h2 class="font-regular font-family-title mx-2">Connectez-vous</h2>
        <form method="post" action="{{ route('login.store') }}">
            @csrf
            <div class=" p-xxs">
                <input type="email" name="email" placeholder="Courriel"
                    class="border border-light-gray/30 w-full p-xxs my-2 rounded-md focus:outline-none focus:light-gray bg-white" value="{{old('email')}}" required />
                @if($errors->has('email'))
                <div>
                    {{$errors->first('email')}}
                </div>
                @endif
                <input type="password" name="password" placeholder="Mot de passe"
                    class="border border-light-gray/30 w-full p-xxs my-2 rounded-md focus:outline-none focus:light-gray " required />
                @if($errors->has('password'))
                <div>
                    {{$errors->first('password')}}
                </div>
                @endif
            </div>

            <div class="hidden p-xs">
                <input type="checkbox" name="terms" class="mr-3" />
                <p class="text-xxs font-light">J'accepte les <span class="font-regular text-">Termes & Politiques de confidentialité</span></p>
                @if($errors->has('terms'))
                <div>
                    {{$errors->first('terms')}}
                </div>
                @endif
            </div>

            <div class="hidden relative flex items-center py-5">
                <div class="flex-grow border-t border-gray-300"></div>
                <span class="flex-shrink mx-4 text-xxs text-light-gray">Continuer avec</span>
                <div class="flex-grow border-t border-gray-300"></div>
            </div>

            <div class="hidden p-xxs flex-col justify-between">
                <button type="button" class="text-xxs w-full p-xs my-2 border border-light-gray/30 rounded-md focus:outline-none focus:light-gray bg-white cursor-pointer flex items-center justify-center">
                    <i class="fab fa-facebook mr-2"></i> Facebook
                </button>
                <button type="button" class="text-xxs w-full p-xs my-2 border border-light-gray/30 rounded-md focus:outline-none focus:light-gray bg-white cursor-pointer flex items-center justify-center">
                    <i class="fab fa-google mr-2"></i> Google
                </button>
                <button type="button" class="text-xxs w-full p-xs my-2 border border-light-gray/30 rounded-md focus:outline-none focus:light-gray bg-white cursor-pointer flex items-center justify-center">
                    <i class="fab fa-apple mr-2"></i> Apple
                </button>
            </div>
            @guest
            <button type="submit" class="bouton w-full">Connexion</button>
            @endguest
        </form>
        @auth
        <div class="mt-2">
            <a href="{{ route('logout') }}" class="bouton w-full block text-center">Déconnexion</a>
        </div>
        @endauth
    </div>
    <p class="text-xxs flex justify-center p-xxs">
        Pas membre? <a href="{{ route('user.create') }}" class="px-xxs underline"> S'inscrire</a>
    </p>

</div>
</div>
@endsection