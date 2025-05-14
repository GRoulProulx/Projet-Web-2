@extends('layouts.app')
@section('title', 'Réinitialiser le mot de passe')
@section('content')

<!-- Page de réinitialisation du mot de passe -->

<div class="border border-light-gray/30 p-md rounded-md flex flex-col gap-sm md:max-w-3xl mx-auto ">
    <div>
        <h1 class="font-family-title mx-2 text-lg">Réinialiser le mot de passe</h1>
        <form method="post">
            @csrf
            @method('put')
            <div class=" p-xxs">
                <input type="password" name="password" placeholder="Mot de passe" aria-labelledby="password"
                    class="border border-light-gray/30 w-full p-xxs my-2 rounded-md focus:outline-none focus:light-gray" required />
            </div>
            <div class=" p-xxs">
                <input type="password" name="password_confirmation" placeholder="Mot de passe" aria-label="password_confirmation"
                    class="border border-light-gray/30 w-full p-xxs my-2 rounded-md focus:outline-none focus:light-gray" required />
            </div>
            <button type="submit" class="bouton w-full">Réinitialiser le mot de passe</button>
        </form>
    </div>
    <p class="text-xxs flex justify-center p-xxs">
        Pas membre? <a href="{{ route('user.create') }}" class="px-xxs underline"> S'inscrire</a>
    </p>
</div>

@endsection