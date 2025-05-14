@extends('layouts.app')
@section('title', 'Mot de passe oublié')
@section('content')

<section class="md:max-w-3xl mx-auto">
    <header class="mb-sm">
        <h1 class="font-family-title text-lg">Mot de passe oublié</h1>
    </header>
    <!-- Formulaire pour mot de passe oublié -->
    <form method="POST" class="flex flex-col gap-sm ">
        @csrf
        <input type="text" id="name" name="name" value="{{ old('courriel') }}" placeholder="Courriel" aria-label="Courriel" class="border border-light-gray/30 rounded-md p-xs">
        
        <button type="submit" class="bouton mt-0">Mot de passe oublié</button>
    </form>
    <div class="text-center mt-md">
        <a href="{{ route('login') }}" class="link-underline-hover"><i class="fa-solid fa-circle-arrow-left mr-2.5"></i>Annuler</a>
    </div>
</section>
@endsection