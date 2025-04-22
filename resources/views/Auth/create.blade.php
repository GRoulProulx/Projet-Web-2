@extends('layouts.app')
@section('content')

<!-- Page de Connexion -->

<div class="bg-light-gray p-md rounded-sm">
    <div class="">
        <h2 class="font-regular font-family-title mx-2">Connectez-vous</h2>

        <form action="{{ route('login') }}" method=" post">
            @csrf
            <div class="p-xxs">
                <input type="text" placeholder="Nom d'utilisateur"
                    class="w-full p-xxs my-2 rounded-md focus:outline-none focus:light-gray bg-white" />
                <input type="email" placeholder="Courriel"
                    class="w-full p-xxs my-2 rounded-md focus:outline-none focus:light-gray bg-white" />
                <input type="password" placeholder="Mot de passe"
                    class="w-full p-xxs my-2 rounded-md focus:outline-none focus:light-gray bg-white" />
            </div>

            <div class="flex p-xs">
                <input type="checkbox" class="mr-3" />
                <p class="text-xxs font-light">J'accepte les <span class="font-regular text-">Termes & Politiques de confidentialité</span></p>
            </div>
        </form>

        <div class="">
            <hr class="">
            <span class="text-xxs flex justify-center">
                Continuer avec
            </span>
        </div>

        <div class="p-xxs flex-col justify-between">
            <button class="text-xxs w-full p-xs m-2 border rounded-md focus:outline-none focus:light-gray bg-white cursor-pointer">
                <i class="fab fa-facebook"></i> Facebook
            </button>
            <button class="text-xxs w-full p-xs m-2 border rounded-md focus:outline-none focus:light-gray bg-white cursor-pointer">
                <i class="fab fa-google"></i> Google
            </button>
            <button class="text-xxs w-full p-xs m-2 border rounded-md focus:outline-none focus:light-gray bg-white cursor-pointer">
                <i class="fab fa-apple"></i> Apple
            </button>
        </div>

        <button type="submit" class="bouton w-full">Je m'inscris</button>

        <p class="text-xxs flex justify-center p-xxs">
            Déjà membre? <a href="#" class="px-xxs underline"> Se connecter</a>
        </p>
    </div>
</div>
@endsection