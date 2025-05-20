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
                            <form action="{{ route('shoppingList.destroy', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" aria-label="Supprimer">
                                    <i class="fa-solid fa-trash text-md text-alert cursor-pointer"></i>
                                </button>
                            </form>
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

@endsection