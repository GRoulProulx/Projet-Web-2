@extends('layouts.app')
@section('title', 'Détails d\'un vin')
@section('content')

<section>
    <article class="mx-auto relative max-w-3xl border border-light-gray/30 rounded-md p-sm">
        <i class="fa-regular fa-heart absolute top-sm left-sm text-lg text-taupe"></i>
        <div class="flex gap-sm flex-wrap">
            <img src="{{ $bottle->image }}" alt="{{ $bottle->name }}" class="object-cover mx-auto">
            <div class="flex flex-col gap-xxs">
                <header>
                    <h2 class="text-lg uppercase max-w-lg">{{ $bottle->name }}</h2>
                </header>
                <div class="flex gap-xs flex-wrap">
                    <p>{{ $bottle->type }}</p>
                    <div class="border-2 border-l border-light-gray"></div>
                    <p>{{ $bottle->format }}</p>
                    <div class="border-2 border-l border-light-gray"></div>
                    <p>{{ $bottle->country }}</p>
                </div>
                <div class="flex flex-col gap-y-xs">
                    <p>{{ $bottle->price}}</p>
                    <form action="">
                        <input aria-label="Ajouter à mon cellier" type="number" name="quantity" id="quantity" value="1" min="1" class="border border-light-gray rounded-md py-xxs px-xxs w-20">
                        <button type="submit" class="bouton mt-xs">Ajouter à mon cellier</button>
                    </form>
                    <p>Code: {{ $bottle->code_saq}}</p>
                    <a href="{{ $bottle->url}}">Commander à la SAQ <i class="fa-solid fa-arrow-up-right-from-square text-taupe"></i></a>
                </div>
            </div>
        </div>
    </article>
    <div class="mt-md text-center">
        <a href="{{ route('bottle.index') }}" class="bouton white">Retour à la liste</a>
    </div>
</section>

@endsection