@extends('layouts.app')
@section('title', 'Connexion')
@section('content')

<!-- Page de Connexion -->
<section class="border border-light-gray/30 p-md rounded-md flex flex-col gap-sm md:max-w-3xl mx-auto ">
    <div>
        <header>
            <h1 class="font-family-title text-lg">Connectez-vous</h1>
        </header>
        <form method="post" action="{{ route('login.store') }}">
            @csrf
            <div>
                <input type="email" name="email" placeholder="Courriel"
                    class="border border-light-gray/30 w-full p-xxs my-2 rounded-md focus:outline-none focus:light-gray bg-white" value="{{old('email')}}" aria-label="Courriel" required />
                <input type="password" name="password" placeholder="Mot de passe"
                    class="border border-light-gray/30 w-full p-xxs my-2 rounded-md focus:outline-none focus:light-gray" aria-label="Mot de passe" required />
            </div>
            <a href="{{ route('user.forgot') }}" class="px-xxs underline text-taupe"><small>Mot de passe oublié?</small></a>
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
</section>

@endsection