@extends('layouts.app')
@section('title', trans('Liste des bouteilles'))
@section('content')

<section>
    <div class="py-md sm:py-md">
        <div class="mx-auto">
            <div class="mx-auto">
                <h1 class="font-family-title text-xl">Catalogue des bouteilles</h1>
                <p class="text-lg text-gray-600">Trouvez la bouteille qui vous fait rêver</p>
            </div>

            <div class="mx-auto grid max-w-2xl grid-cols-1 gap-sm gap-y-md mt-md lg:mx-0 lg:max-w-none lg:grid-cols-3">
                @foreach($bottles as $bottle)
                <a href="{{ route('bottle.show', $bottle->id) }}">
                    <article class="flex max-w-xl min-h-full flex-col items-start justify-between border border-light-gray/30 rounded-md p-sm hover:border-light-gray/60 transition duration-300 ease-in-out">
                        <div class="flex items-center gap-x-4 text-xs">
                            <img src="{{ $bottle->image }}" alt="{{ $bottle->name }}" class="object-cover">
                            <div class="flex flex-col gap-xxs">
                                <header>
                                    <h2 class="text-lg uppercase">{{ $bottle->name }}</h2>
                                </header>
                                <div class="flex gap-xs">
                                    <p>{{ $bottle->type }}</p>
                                    <div class="border-2 border-l border-light-gray"></div>
                                    <p>{{ $bottle->format }}</p>
                                    <div class="border-2 border-l border-light-gray"></div>
                                    <p>{{ $bottle->country }}</p>
                                </div>
                            </div>

                        </div>
                    </article>
                </a>
                @endforeach
            </div>
        </div>
    </div>
    <a href="{{ route('bottle.create') }}" class="bouton">Ajouter une bouteille</a>
    </div>
</section>

@endsection