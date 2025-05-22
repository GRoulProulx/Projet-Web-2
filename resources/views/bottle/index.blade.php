@extends('layouts.app')
@section('title', 'Catalogue des vins')
@section('content')

<section>
    <div>
        <div class="mx-auto">
            <!-- Grand titre -->
            <header class="max-w-5xl">
                @if(Auth::check())
                <h1 class="font-family-title text-lg">Catalogue des vins</h1>
                <p>
                    Bienvenue dans votre espace de découverte! Filtrez, explorez et ajoutez des vins à votre cellier pour enrichir votre collection et suivre vos préférences en toute simplicité.
                </p>
                @else
                <h1 class="font-family-title text-lg">Bienvenue !</h1>
                <p>
                    Profitez pleinement de l’application :
                    <a href="{{ route('login') }}" class="underline underline-offset-3 text-taupe">identifiez-vous</a>
                    ou
                    <a href="{{ route('user.create') }}" class="underline underline-offset-3 text-taupe">créez un compte</a>
                    pour ajouter des vins à votre cellier, gérer vos listes et accéder à toutes les fonctionnalités.
                </p>
                @endif
            </header>
            <div class="flex flex-col md:auto pt-md gap-md">
                <!-- La barre de recherche -->
                <form method="GET" action="{{ route('search') }}" class="searchForm flex">
                    @method('GET')
                    <input
                        id="search"
                        name="search"
                        type="text"
                        placeholder="Rechercher un vin"
                        class=" grow sm:grow-0 border border-light-gray rounded-l-md rounded-r-none py-1 px-3 w-50 text-center"
                        value="{{ request()->get('search') }}">
                    <button type="submit" class="bouton blue-magenta py-1 px-3 text-sm rounded-r-md rounded-l-none sm:w-auto mt-0 sm:mt-0">Recherche</button>
                </form>
            </div>
            <details class="mt-md">

                <summary class="text-blue-magenta font-family-title text-md">Filtres</summary>
                <!--Formulaire de trie-->
                <form method="GET" action="{{ route('bottle.index') }}" class="mb-md grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-sm mt-3">
                    <!--Filtre par pays-->
                    <div>
                        <label for="country">Pays :</label>
                        <select name="country" id="country" class="w-full border border-light-gray/30 rounded px-1 py-2 text-center ">
                            <option value="" class="field-sizing-content">-- Tous les pays -- </option>
                            @foreach($allCountries as $country)
                            <option value="{{ $country }}" {{ request('country') == $country ? 'selected' : '' }}>{{ $country }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!--Filtre par type-->
                    <div>
                        <label for="type">Type :</label>
                        <select name="type" id="type" class="w-full border border-light-gray/30 rounded px-1 py-2 text-center">
                            <option value="">-- Tous les types --</option>
                            @foreach($allTypes as $type)
                            <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex gap-3">
                        <div class="w-1/2">
                            <!--Filtre prix minimum-->
                            <label for="min_price">Prix min :</label>
                            <input type="number" step="0.01" name="min_price" id="min_price" value="{{ request('min_price') }}" class="w-full border border-light-gray/30 rounded px-1 py-2 ">
                        </div>
                        <!--Filtre prix max-->
                        <div class="w-1/2">
                            <label for="max_price">Prix max :</label>
                            <input type="number" step="0.01" name="max_price" id="max_price" value="{{ request('max_price') }}" class="w-full border border-light-gray/30 rounded px-1 py-2">
                        </div>
                    </div>

                    <!-- autres filtres pour tri -->
                    <div>
                        <label for="sort_by" class="">Filter par : </label>
                        <select name="sort_by" id="sort_by" class="w-full border border-light-gray/30 rounded px-1 py-2 text-center">

                            <option value="">-- Aucun tri --</option>
                            <option value="name_asc" {{ request('sort_by') == 'name_asc' ? 'selected' : '' }}>Nom (A-Z)</option>
                            <option value="name_desc" {{ request('sort_by') == 'name_desc' ? 'selected' : '' }}>Nom (Z-A)</option>
                            <option value="country_asc" {{ request('sort_by') == 'country_asc' ? 'selected' : '' }}>Pays (A-Z)</option>
                            <option value="country_desc" {{ request('sort_by') == 'country_desc' ? 'selected' : '' }}>Pays (Z-A)</option>
                            <option value="price_asc" {{ request('sort_by') == 'price_asc' ? 'selected' : '' }}>Prix (croissant)</option>
                            <option value="price_desc" {{ request('sort_by') == 'price_desc' ? 'selected' : '' }}>Prix (décroissant)</option>
                            <option value="type_asc" {{ request('sort_by') == 'type_asc' ? 'selected' : '' }}>Type (A-Z)</option>
                            <option value="type_desc" {{ request('sort_by') == 'type_desc' ? 'selected' : '' }}>Type (Z-A)</option>
                        </select>
                    </div>
                    <button type="submit" class="bouton blue-magenta mt-0 font-family-title"> <i class="fa-solid fa-filter mr-base"></i> Filtrer</button>
                </form>
            </details>
            <div class="mt-md">
                <p><strong>Sélection: </strong>{{$bottles->total()}} bouteilles</p>
            </div>

            <!-- Grille des produits -->
            <div class="mx-auto grid max-w-2xl grid-cols-1 gap-sm gap-y-sm mt-md md:mx-0 md:max-w-none md:grid-cols-2 xl:grid-cols-3 ">
                @foreach($bottles as $bottle)
                <a href="{{ route('bottle.show', $bottle->id) }}" class="border border-light-gray/20 rounded-md shadow p-md hover:shadow-md transition-all duration-300 hover:border-light-gray/40 relative">
                    @auth
                    <div class="absolute top-2 right-2">
                        <form action="{{ route('shoppingList.store', $bottle->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-taupe hover:text-blue-magenta transition-colors">
                                <i class="fa-solid fa-cart-arrow-down text-lg p-sm cursor-pointer"></i>
                            </button>
                        </form>
                    </div>
                    @endauth
                    <article>
                        <figure class="flex flex-col sm:flex-row gap-sm text-sm">
                            <img src="{{ $bottle->image }}" alt="{{ $bottle->name }}" class="mx-auto sm:mx-0 max-w-[111px] max-h-[166px] object-cover">
                            <figcaption class="flex flex-col gap-md justify-between">
                                <div class="flex flex-col sm:gap-xs">
                                    <header>
                                        <h2 class="text-md uppercase">{{ $bottle->name }}</h2>
                                    </header>
                                    <div class="flex gap-xs flex-wrap">
                                        <p class="type">{{ $bottle->type }}</p>
                                        <div class="border-2 border-l border-light-gray"></div>
                                        <p class="format">{{ $bottle->format }}</p>
                                        <div class="border-2 border-l border-light-gray"></div>
                                        <p class="country">{{ $bottle->country }}</p>
                                    </div>
                                </div>
                                <p class="w-fit text-md text-taupe link-underline-hover ">Ajouter au cellier <i class="fa-solid fa-circle-arrow-right text-base"></i></p>
                            </figcaption>
                        </figure>
                    </article>
                </a>
                @endforeach
            </div>

            <div class="my-md">
                @if(method_exists($bottles, 'links'))
                {{ $bottles->appends(request()->input())->links() }}
                @endif
            </div>
        </div>
    </div>
</section>

@endsection