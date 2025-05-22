@extends('layouts.app')
@section('title', 'Mon cellier')

@section('content')
<section class="my_cellar mx-auto">
    <!-- En-tête de la page -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-sm ">
        <header class="flex items-center justify-between gap-md mb-sm mr-lg">
            <h1 class="text-lg font-family-title flex items-baseline gap-xxs flex-nowrap">
                Cellier: <span class="font-family">{{ $cellar->name }}</span>
            </h1>
            <div class="flex gap-lg ">
                <a href="{{route('cellar.edit', $cellar->id)}}" aria-label="Modifier le cellier"><i class="fa-solid fa-pen-to-square text-md"></i></a>
                <a href="#" data-action="delete" aria-label="Icône poubelle pour supprimer le cellier"><i class="fa-solid fa-trash text-md text-alert"></i></a>
            </div>
            <input type="hidden" id="cellar_id" value="{{$cellar->id}}">
        </header>
        <div class="flex gap-xxs justify-between flex-wrap sm:flex-nowrap mt-sm mb-sm ">
            <a href="{{ route('bottle.index') }}" class="bouton mt-0 grow md:grow-0 text-center"><i class="fa fa-plus mr-xs" aria-hidden="true"></i>Ajouter une bouteille</a>
            <a href="{{ route('custom-bottles.create') }}" class="bouton white mt-0 grow md:grow-0 text-center"><i class="fa fa-plus mr-xs" aria-hidden="true"></i>Ajouter une bouteille personnalisée</a>
        </div>
    </div>

    <!-- La recherche -->
    <div class="flex flex-col">
        <form method="GET" action="{{ route('searchCellar', $cellar->id) }}" class="flex">
            @method('GET')
            <input
                id="search"
                name="search"
                type="text"
                placeholder="Rechercher un vin"
                class="border border-light-gray rounded-l-md rounded-r-none py-xs px-md w-91 h-12 text-center"
                value="{{ request()->get('searchInCellar') }}">
            <button type="submit" class="bouton blue-magenta py-1 px-6 text-sm rounded-r-md rounded-l-none sm:w-auto mt-0 sm:mt-0">Recherche</button>
        </form>
    </div>

    <details class="mt-md">

        <summary class="text-blue-magenta font-family-title text-md">Filtres</summary>
        <!-- Formulaire de tri -->
        <form method="GET" class="mb-md grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-sm mt-3">
            <div>
                <select name="sort_by" id="sort_by" class="w-full border border-light-gray/30 rounded px-1 py-2 text-center">
                    <option value="name" {{ request('sort_by') === 'name' ? 'selected' : '' }}>Nom</option>
                    <option value="price" {{ request('sort_by') === 'price' ? 'selected' : '' }}>Prix</option>
                    <option value="purchase_date" {{ request('sort_by') === 'purchase_date' ? 'selected' : '' }}>Date d'achat</option>
                </select>
            </div>

            <div>
                <select name="order" class="w-full border border-light-gray/30 rounded px-1 py-2 text-center">
                    <option value="asc" {{ request('order') === 'asc' ? 'selected' : '' }}>Croissant</option>
                    <option value="desc" {{ request('order') === 'desc' ? 'selected' : '' }}>Décroissant</option>
                </select>
            </div>


            <button type="submit" class="bouton blue-magenta mt-0 font-family-title"> <i class="fa-solid fa-filter mr-base"></i>Filtrer</button>
        </form>
    </details>

    <!-- Bouteilles du cellier -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-sm mb-sm">
        @foreach ($cellarBottles as $cellarBottle)
        <div class="border border-light-gray/20 rounded-lg shadow p-md flex flex-col gap-sm justify-between relative hover:shadow-md transition-all duration-300 hover:border-light-gray/40">
            <a href="{{ route('cellar_bottle.show', $cellarBottle->id) }}" class="flex flex-col sm:flex-row gap-sm">

                <!-- Image -->
                <div class="flex-shrink-0">
                    @php

                        $image = $cellarBottle->bottle->image;
                        $isExternal = Str::startsWith($image, ['http://', 'https://']);
                    @endphp

                    @if ($image)
                    <img src="{{ $isExternal ? $image : asset($image) }}" alt="{{ $cellarBottle->bottle->name }}" class="mx-auto sm:mx-0 max-w-[100px] max-h-[150px] object-cover rounded-md">
                    @else
                    <div class="bg-gray-100 flex items-center justify-center rounded-md w-[100px] h-[150px]">
                        <span class="text-gray-400">Aucune image</span>
                    </div>
                    @endif
                </div>

                <!-- Informations -->
                <div class="flex-grow">
                    <h2 class="xs:text-base sm:text-base md:text-md uppercase mb-2">{{ $cellarBottle->bottle->name }}</h2>
                    <div class="flex gap-xs flex-wrap">
                        <p>{{ $cellarBottle->bottle->type }}</p>
                        <div class="border-2 border-l border-light-gray"></div>
                        <p>{{ $cellarBottle->bottle->format }}</p>
                        <div class="border-2 border-l border-light-gray"></div>
                        <p>{{ $cellarBottle->bottle->country }}</p>
                    </div>
                </div>
            </a>
            <!-- Formulaire de consommation -->
            <div class="flex justify-between items-baseline-last flex-wrap gap-sm">
                <form action="{{ route('cellar_bottle.drink', $cellarBottle->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="flex flex-col">
                        <label for="quantity{{$cellarBottle->id}}" class="font-regular">Retirer du cellier: </label>
                        <div class="flex">
                            <input type="hidden" id="bottle_id" name="bottle_id" value="{{$cellarBottle->bottle->id}}">
                            <input type="number" id="quantity{{$cellarBottle->id}}" name="quantity" min="1" max="{{$cellarBottle->quantity}}" value="{{$cellarBottle->quantity}}" readonly class="border border-light-gray rounded-l-md rounded-r-none py-1 px-3 w-20 text-center">
                            <button type="submit" class="bouton py-1 px-3 text-sm rounded-r-md rounded-l-none sm:w-auto mt-0 sm:mt-0">Boire</button>
                        </div>
                    </div>
                </form>
                <a href="{{ route('cellar_bottle.show', $cellarBottle->id) }}" class="w-fit text-md text-taupe link-underline-hover">
                    Détails <i class="fa-solid fa-circle-arrow-right text-base"></i>
                </a>
            </div>

            <!-- Informations supplémentaires -->
            <div class="border-t border-light-gray/30 mt-2 pt-2">
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <span class="text-gray-500 text-sm font-medium">Date d'achat:</span>
                        <p>@if(!$cellarBottle->purchase_date){{date_format($cellarBottle->created_at, "Y-m-d")}} @else{{$cellarBottle->purchase_date}} @endif</p>
                    </div>
                    <div>
                        <span class="text-gray-500 text-sm font-medium">Conservation:</span>
                        <p>{{ $cellarBottle->storage_until ?? '-' }}</p>
                    </div>
                </div>
                <div class="mt-2">
                    <span class="text-gray-500 text-sm font-medium">Notes:</span>
                    <p>{{ $cellarBottle->notes ?? '-' }}</p>
                </div>
            </div>

            <div class="border-t border-light-gray/30 mt-2 pt-2">

                <!-- Formulaire de deplacement -->
                <div class="flex justify-between items-baseline-last flex-wrap gap-sm">
                    @auth
                    @if(auth()->user()->cellars->count() > 1)
                    <form action="{{ route('cellar.moveBottle') }}" method="POST">

                        @csrf
                        <div class="flex flex-col">
                            <label for="quantity{{$cellarBottle->id}}" class="font-regular">Déplacer vers : </label>
                            <ul class="text-sm text-gray-600 mb-sm list-disc list-inside">
                                <li>Indiquez la quantité à déplacer</li>
                                <li>Choisissez le cellier de destination</li>
                            </ul>
                            <div class="flex flex-col md:flex-row">
                                <input type="hidden" name="bottle_id" value="{{ $cellarBottle->bottle_id }}">
                                <input type="hidden" name="from_cellar_id" value="{{ $cellar->id }}">
                                <input type="number" name="quantity" value="1" min="1" max="{{ $cellarBottle->quantity }}" class="border border-light-gray rounded-t-md md:rounded-l-md md:rounded-r-none py-1 px-xxs text-center">
                                <select name="to_cellar_id" required class="border border-light-gray py-1 px-xs text-sm sm:w-auto mt-0 sm:mt-0">
                                    <option value="">Choisir un cellier</option>
                                    @foreach (auth()->user()->cellars->where('id', '!=', $cellar->id) as $otherCellar)
                                    <option value="{{ $otherCellar->id }}">{{ $otherCellar->name }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="bouton blue-magenta py-1 px-xs text-sm rounded-b-md rounded-t-none md:rounded-r-md md:rounded-l-none sm:w-auto mt-0 sm:mt-0">Déplacer</button>
                            </div>
                        </div>
                    </form>
                    @endif
                @endauth
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Message si le cellier est vide -->
    @if ($cellarBottles->isEmpty())
    <div class="bg-white border border-light-gray/20 rounded-lg shadow p-8 text-center">
        <p class="text-lg font-family color-light-gray mb-4">Ce cellier ne contient aucune bouteille.</p>
    </div>
    @endif

    <!-- Retour -->
    <div class="text-center mt-md">
        <a href="{{ route('cellar.index') }}" class="link-underline-hover">
            <i class="fa-solid fa-circle-arrow-left mr-2.5"></i>Retour à mes celliers
        </a>
    </div>
    {{-- <div class="text-center mt-md">
        <a href="{{ route('custom-bottles.create') }}" class="link-underline-hover">
    Ajouter une bouteille personalisée <i class="fa-solid fa-circle-arrow-right ml-2.5"></i>
    </a>
    </div> --}}
</section>


<!-- Modale -->
<div class="modale-container hidden relative z-10">
    <div class="modale fixed inset-0 bg-gray-500/75 transition-opacity">
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="modale-header flex items-start justify-between">
                            <h2 class="font-family-title text-lg uppercase">Supprimer le cellier</h2>
                            <a href=""><i class="fa-solid fa-xmark"></i></a>
                        </div>
                        <div class="modale-body">
                            <p>Êtes-vous sûr de vouloir supprimer ce cellier?</p>
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