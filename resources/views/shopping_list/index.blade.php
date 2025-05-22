@extends('layouts.app')
@section('title', 'Liste d\'achat')
@section('content')

<section>
    <div>
        <div class="mx-auto">
            <!-- Grand titre -->
            <header class="max-w-5xl">
                <h1 class="font-family-title text-lg">Liste d'achat</h1>
                <p>Voici votre liste d'achat. C'est ici que vous pourriez organiser vos prochains achats.</p>
                <p class="mt-sm font-semibold">Total: {{ number_format($shoppingListItems->sum(function($item) { return $item->bottle->price; }), 2, '.', ' ') }} $</p>
            </header>

            <!-- Grille des produits -->
            <div class="mx-auto grid max-w-2xl grid-cols-1 gap-sm gap-y-sm mt-md md:mx-0 md:max-w-none md:grid-cols-2 xl:grid-cols-3 ">
                @forelse($shoppingListItems as $item)
                <div href="" class="border border-light-gray/20 rounded-md shadow p-md transition-all duration-300 hover:border-light-gray/40">
                    <article>
                        <div class="flex justify-end">
                            <a href="#" data-action="deleteItemShoppingList" data-id="{{ $item->id }}" data-name="{{ $item->name }}" aria-label="Icône poubelle pour supprimer l'utilisateur">
                                <i class="fa-solid fa-trash text-md text-alert"></i>
                            </a>
                        </div>
                        <figure class="flex flex-col sm:flex-row gap-sm text-sm">
                            <img src="{{ $item->bottle->image }}" alt="{{ $item->bottle->name }}" class="mx-auto sm:mx-0 max-w-[111px] max-h-[166px] object-cover">
                            <figcaption class="flex flex-col gap-md justify-between">
                                <div class="flex flex-col sm:gap-xs">
                                    <header>
                                        <h2 class="text-md uppercase">{{ $item->bottle->name }}</h2>
                                    </header>
                                    <div class="flex gap-xs flex-wrap">
                                        <p class="type">{{ $item->bottle->type }}</p>
                                        <div class="border-2 border-l border-light-gray"></div>
                                        <p class="format">{{ $item->bottle->format }}</p>
                                        <div class="border-2 border-l border-light-gray"></div>
                                        <p class="country">{{ $item->bottle->country }}</p>
                                    </div>
                                    <div class="mt-2">
                                        <p class="price">{{ $item->bottle->price }} $</p>
                                    </div>
                                </div>
                            </figcaption>
                        </figure>
                    </article>
                </div>
                @empty
                <div class="col-span-full text-center p-md">
                    <p>Votre liste d'achat est vide.</p>
                </div>
                @endforelse
            </div>
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
                            <h2 class="font-family-title text-lg uppercase">Supprimer cette bouteille de la liste d'achat?</h2>
                            <a href=""><i class="fa-solid fa-xmark"></i></a>
                        </div>
                        <div class="modale-body">
                            <p>
                            <p>Êtes-vous sûr de vouloir supprimer cette bouteille<span id="modalItemName"></span>?</p>
                            </p>
                        </div>
                        <div class="modale-footer flex justify-between items-baseline">
                            <a href="" class="bouton blue-magenta">Annuler</a>
                            <form action="" method="POST" id="deleteItemShoppingListForm">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bouton alert mt-0">Supprimer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection