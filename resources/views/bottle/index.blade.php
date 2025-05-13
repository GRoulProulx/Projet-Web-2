@extends('layouts.app')
@section('title', 'Catalogue des vins')
@section('content')

<section>
    <div>
        <div class="mx-auto">
            <!-- Grand titre -->
            <header class="max-w-5xl">
                <h1 class="font-family-title text-lg">Catalogue des vins</h1>
                <p>Explorez une vaste sélection de vins directement issus de la SAQ. Recherchez, filtrez selon vos préférences et ajoutez vos découvertes à votre cellier en toute simplicité.</p>
            </header>
            <!--Formulaire de trie-->
            <form method="GET" action="{{ route('bottle.index') }}" class="mb-md flex  gap-sm items-center mt-lg">
                <div>
                    <label for="sort_by" class=""><i class="fa-solid fa-filter"></i> Trier :</label>
                    <select name="sort_by" id="sort_by" class="border border-light-gray/20 rounded px-2 py-2 mt2 text-center">
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
                <button type="submit" class="bouton blue-magenta mt-0">Appliquer</button>
            </form>
            
            <!-- Grille de produits -->
            <div class="mx-auto grid max-w-2xl grid-cols-1 gap-sm gap-y-sm mt-md md:mx-0 md:max-w-none md:grid-cols-2 xl:grid-cols-3 ">
                @foreach($bottles as $bottle)
                <a href="{{ route('bottle.show', $bottle->id) }}" class="border border-light-gray/20 rounded-md shadow p-md hover:shadow-md transition-all duration-300 hover:border-light-gray/40">
                    <article>
                        <figure class="flex flex-col sm:flex-row gap-sm text-sm">
                            <img src="{{ $bottle->image }}" alt="{{ $bottle->name }}" class="mx-auto sm:mx-0 max-w-[111px] max-h-[166px] object-cover">
                            <figcaption class="flex flex-col gap-md justify-between">
                                <div class="flex flex-col sm:gap-xs">
                                    <header>
                                        <h2 class="text-md uppercase">{{ $bottle->name }}</h2>
                                    </header>
                                    <div class="flex gap-xs flex-wrap">
                                        <p>{{ $bottle->type }}</p>
                                        <div class="border-2 border-l border-light-gray"></div>
                                        <p>{{ $bottle->format }}</p>
                                        <div class="border-2 border-l border-light-gray"></div>
                                        <p>{{ $bottle->country }}</p>
                                    </div>
                                </div>
                                <p class="w-fit text-md text-taupe link-underline-hover ">Ajouter au cellier <i class="ri-arrow-right-circle-fill"></i></p>
                            </figcaption>
                        </figure>
                    </article>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</section>

@endsection