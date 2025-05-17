@extends('layouts.app')
@section('title', 'Mon profil')
@section('content')

<!-- Page de profil utilisateur -->
<section>
    <header class="flex items-center justify-between gap-md mb-sm">
        <h1 class="font-family-title text-lg">Mon profil</h1>
        <div class="flex gap-lg">
            <a href="#" data-action="delete" aria-label="Icone poubelle pour supprimer le profil"><i class="fa-solid fa-trash text-md text-alert"></i></a>
        </div>
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
            <a href="{{ route('auth.edit', auth()->user()->id) }}" class="bouton"><i class="fa-solid fa-user-pen mr-2.5"></i>Modifier mon profil</a>
        </div>
    </div>
</section>

<!-- Modale -->
<div class="modale-container hidden relative z-10">
    <div class="modale fixed inset-0 bg-gray-500/75 transition-opacity">
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="modale-header flex items-start justify-between">
                            <h2 class="font-family-title text-lg uppercase">Supprimer mon profil</h2>
                            <a href=""><i class="fa-solid fa-xmark"></i></a>
                        </div>
                        <div class="modale-body">
                            <p>Êtes-vous sûr de vouloir supprimer votre profil?</p>
                        </div>
                        <div class="modale-footer flex justify-between items-baseline">
                            <a href="" class="bouton blue-magenta">Annuler</a>
                            <form action="" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bouton alert mt-0" data-action="delete">Supprimer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection