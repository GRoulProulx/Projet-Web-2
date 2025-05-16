@extends('layouts.app') 
@section('title', 'Mon cellier')

@section('content')
<section class="my_cellar mx-auto">
    <!-- En-tête de la page -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <header>
            <h1 class="text-lg font-family-title">
                Cellier : <span class="color-taupe font-family">{{ $cellar->name }}</span>
                <a href="{{ route('cellar.edit', $cellar->id) }}"><i class="fa-regular fa-pen-to-square text-md text-taupe"></i></a>
                <input type="hidden" id="cellar_id" value="{{ $cellar->id }}">
            </h1>
        </header>
        <div class="flex gap-xxs justify-between flex-wrap mt-sm mb-sm">
            <a href="{{ route('bottle.index') }}" class="bouton mt-0 grow text-center">
                <i class="fa fa-plus mr-xs" aria-hidden="true"></i>Ajouter une bouteille
            </a>
            <button class="bouton alert mt-0 grow" data-action="delete">Supprimer le cellier</button>
        </div>
    </div>

    <!-- Formulaire de tri -->
    <form method="GET" class="mb-md flex gap-sm flex-wrap items-center">
        <label for="sort_by" class="font-medium">Trier par:</label>
        <select name="sort_by" id="sort_by" class="input">
            <option value="name" {{ request('sort_by') === 'name' ? 'selected' : '' }}>Nom</option>
            <option value="price" {{ request('sort_by') === 'price' ? 'selected' : '' }}>Prix</option>
            <option value="purchase_date" {{ request('sort_by') === 'purchase_date' ? 'selected' : '' }}>Date d'achat</option>
        </select>

        <select name="order" class="input">
            <option value="asc" {{ request('order') === 'asc' ? 'selected' : '' }}>Croissant</option>
            <option value="desc" {{ request('order') === 'desc' ? 'selected' : '' }}>Décroissant</option>
        </select>

        <button type="submit" class="bouton blue-magenta">Trier</button>
    </form>

    <!-- Bouteilles du cellier -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-sm mb-sm">
        @foreach ($cellarBottles as $cellarBottle)
        <div class="border border-light-gray/20 rounded-lg shadow p-md flex flex-col gap-sm justify-between relative hover:shadow-md transition-all duration-300 hover:border-light-gray/40">
            <div class="flex flex-col sm:flex-row gap-sm">
                <!-- Image -->
                <div class="flex-shrink-0">
                    @if ($cellarBottle->bottle->image)
                        <img src="{{ $cellarBottle->bottle->image }}" class="mx-auto sm:mx-0 max-w-[100px] max-h-[150px] object-cover rounded-md" alt="{{ $cellarBottle->bottle->name }}">
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
            </div>

            <!-- Formulaire de consommation -->
            <div class="flex justify-between items-baseline-last flex-wrap gap-sm">
                <form action="{{ route('cellar_bottle.drink', $cellarBottle->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="flex flex-col">
                        <label for="quantity" class="font-regular">Quantité:</label>
                        <div class="flex">
                            <input type="hidden" name="bottle_id" value="{{ $cellarBottle->bottle->id }}">
                            <input type="number" name="quantity" min="1" max="{{ $cellarBottle->quantity }}" value="{{ $cellarBottle->quantity }}" class="border border-light-gray rounded-l-md py-1 px-3 w-20 text-center">
                            <button type="submit" class="bouton py-1 px-3 text-sm rounded-r-md">Boire</button>
                        </div>
                    </div>
                </form>
                <a href="{{ route('cellar_bottle.show', $cellarBottle->id) }}" class="w-fit text-md text-taupe link-underline-hover">
                    Détails <i class="fa-solid fa-circle-arrow-right text-base"></i>
                </a>
            </div>

            <!-- Informations supplémentaires -->
            <div class="border-t border-light-gray/20 mt-2 pt-2">
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <span class="text-gray-500 text-sm font-medium">Date d'achat:</span>
                        <p>{{ $cellarBottle->purchase_date ?? '-' }}</p>
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
</section>
@endsection
