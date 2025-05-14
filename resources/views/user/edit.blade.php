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
        <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" placeholder="Nom" aria-label="Nom" class="border border-light-gray/30 rounded-md p-xs" required>
        <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" placeholder="Email" aria-label="Email" class="border border-light-gray/30 rounded-md p-xs" required>
        <button type="submit" class="bouton mt-0">Sauvegarder</button>
    </form>
    <div class="text-center mt-sm">
        <a href="{{ route('user.show', auth()->user()->id) }}" class="link-underline-hover inline-flex"><i class="fa-solid fa-circle-arrow-left mr-2.5"></i></p> Retour à mon profil</a>
    </div>
</section>

@endsection