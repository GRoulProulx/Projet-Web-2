@extends('layouts.app')
@section('title', 'Modifier mon profil')
@section('content')

<section class="flex flex-col gap-sm md:max-w-3xl mx-auto">
    <header>
        <h1 class="font-family-title text-lg">Modifier mon profil</h1>
    </header>
    <!-- Formulaire pour modifier son profil -->
    <form method="POST" class="flex flex-col gap-sm">
        @csrf
        @method('PUT')
        <div class="flex flex-col gap-xxs">
            <label for="name">Nom</label>
            <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" placeholder="Nom" class="border border-light-gray/30 rounded-md p-xs" required>
        </div>

        <div class="flex flex-col gap-xxs">
            <label for="email">Courriel</label>
            <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" placeholder="Email" class="border border-light-gray/30 rounded-md p-xs" required>
        </div>

        <div class="flex flex-col gap-xxs">
            <label for="password">Mot de passe</span></label>
            <input type="password" id="password" name="password" placeholder="Mot de passe" class="border border-light-gray/30 rounded-md p-xs">
            <small class="text-taupe">Laisser vide pour conserver votre mot de passe actuel.</small>
        </div>

        <div class="flex flex-col gap-xxs">
            <label for="password_confirm">Confirmation du mot de passe</label>
            <input type="password" id="password_confirm" name="password_confirmation" placeholder="Confirmer le mot de passe" class="border border-light-gray/30 rounded-md p-xs">
            <small class="text-taupe">Laisser vide pour conserver votre mot de passe actuel.</small>
        </div>
        <button type="submit" class="bouton mt-0">Sauvegarder</button>
    </form>
    <div class="text-center mt-sm">
        <a href="{{ route('auth.show', auth()->user()->id) }}" class="link-underline-hover inline-flex"><i class="fa-solid fa-circle-arrow-left mr-2.5"></i></p> Retour à mon profil</a>
    </div>
</section>

@endsection