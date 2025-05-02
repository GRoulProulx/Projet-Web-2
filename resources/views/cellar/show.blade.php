@extends('layouts.app')
@section('title', 'Cellier')
@section('content')

<div class="container mx-auto px-4 py-6">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-family-title font-weight-regular">Cellier : <span class="color-taupe font-family">{{ $cellar->name }}</span></h1>
    </div>

    @if ($cellar->cellarBottles->isEmpty())
    <p class="text-md font-family color-light-gray">Ce cellier ne contient aucune bouteille.</p>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
        @foreach ($cellar->cellarBottles as $cellarbottle)
        <a href="{{route('cellar_bottle.show', $cellarbottle->id)}}" class="bg-white border border-light-gray/20 rounded-lg shadow p-4 flex flex-col justify-between relative">

            {{-- Image  --}}
            @if ($cellarbottle->bottle->image)
            <img src="{{ $cellarbottle->bottle->image }}" class="max-w-[111px] max-h-[166px] object-cover">
            @endif

            {{-- Nom de la bouteille --}}
            <h2 class="text-lg font-semibold font-family color--taupe mb-1">{{$cellarbottle->bottle->name}} — {{ $cellarbottle->bottle->country }} — {{ $cellarbottle->bottle->format }}</h2>
            {{$cellarbottle->purchase_date}}
            {{$cellarbottle->notes}}
            {{$cellarbottle->storage_until}}
        </a>
        @endforeach

    </div>
    @endif

    {{-- Ajouter une bouteille --}}
    <!-- TODO: AJOUTER BOUTEILLE À VALIDER-->

</div>
@endsection