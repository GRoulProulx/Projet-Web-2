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

            <!-- Grille de produits -->
            <div class="mx-auto grid max-w-2xl grid-cols-1 gap-sm gap-y-sm mt-md md:mx-0 md:max-w-none md:grid-cols-2 xl:grid-cols-3 ">
                @foreach($bottles as $bottle)
                <a href="{{ route('bottle.show', $bottle->id) }}">
                    <article class="flex max-w-full min-h-full flex-col items-start justify-between border border-light-gray/30 rounded-md p-sm hover:border-light-gray/60 transition duration-300 ease-in-out">
                        <figure class="flex gap-x-sm xs:gap-x-xs s:gap-x-sm text-xs">
                            <img src="{{ $bottle->image }}" alt="{{ $bottle->name }}" class="max-w-[111px] max-h-[166px] object-cover">
                            <figcaption class="flex flex-col gap-xxs flex-wrap">
                                <header>
                                    <h2 class="xs:text-base sm:text-md md:text-lg uppercase">{{ $bottle->name }}</h2>
                                </header>
                                <div class="flex gap-xs flex-wrap">
                                    <p>{{ $bottle->type }}</p>
                                    <div class="border-2 border-l border-light-gray"></div>
                                    <p>{{ $bottle->format }}</p>
                                    <div class="border-2 border-l border-light-gray"></div>
                                    <p>{{ $bottle->country }}</p>
                                </div>
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