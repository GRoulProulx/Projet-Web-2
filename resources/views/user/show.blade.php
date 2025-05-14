@extends('layouts.app')
@section('title', 'Mon profil')
@section('content')

<!-- Page de profil utilisateur -->
<section>
    <header class="mb-sm">
        <h1 class="font-family-title text-lg">Mon profil</h1>
    </header>
    <div class="border border-light-gray/30 p-md rounded-md flex flex-col gap-sm md:max-w-3xl mx-auto ">
        <div>
            <header class="mb-sm">
                <h2 class="font-family-title text-md">Informations personnelles</h2>
            </header>
            <p><strong>Nom:</strong> {{ auth()->user()->name }}</p>
            <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
        </div>
        <div class="text-center mt-md">
            <a href="{{ route('user.edit', auth()->user()->id) }}" class="bouton"><i class="fa-solid fa-user-pen mr-2.5"></i>Modifier mon profil</a>
        </div>
    </div>
</section>
@endsection