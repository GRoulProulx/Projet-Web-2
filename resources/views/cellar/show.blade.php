@extends('layouts.app')
@section('title', 'Cellier')
@section('content')

<div class="container mx-auto px-4 py-6">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-family-title font-weight-regular">Cellier : <span class="color-taupe font-family">{{-- {{ $cellar->name }} --}}Banza</span></h1>
    </div>

    @if ($cellar->bottles->isEmpty())
        <p class="text-md font-family color-light-gray">Ce cellier ne contient aucune bouteille.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
            @foreach ($cellar->bottles as $bottle)
                <div class="bg-white border border-light-gray/20 rounded-lg shadow p-4 flex flex-col justify-between relative">

                    {{-- Image  --}}
                    @if ($bottle->image)
                        <img src="{{ $bottle->image }}" alt="{{ $bottle->name }}" class="h-40 w-full object-cover rounded mb-3">
                    @endif

                    <h2 class="text-lg font-semibold font-family color--taupe mb-1">{{ $bottle->name }}</h2>
                    <p class="text-sm font-family text-gray-500 mb-4">{{ $bottle->country }} — {{ $bottle->format }}</p>

                    <div class="flex justify-between items-center mt-auto">
                        {{-- Modifier --}}
                        <a href="{{ route('bottle.edit', [$cellar->id, $bottles->id]) }}"
                           class="bouton blue-magenta mt-0">
                            Modifier
                        </a>

                        {{-- Supprimer --}}
                        <form method="POST" action="{{ route('bottle.destroy', [$cellar->id, $bottle->id]) }}"
                              onsubmit="return confirm('Supprimer cette bouteille ?')">
                            @csrf
                            @method('DELETE')
                            <button class="bouton alert text mt-0">
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Ajouter une bouteille --}}
    <div class="text-center mt-8">
        <a href="{{ route('bottle.create', ['cellar' => $cellar->id]) }}" class="bouton">
            + Ajouter une bouteille
        </a>
    </div>
</div>
@endsection
