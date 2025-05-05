@extends('layouts.app')
@section('title', 'Cellier')
@section('content')

<div class="container mx-auto px-4 py-8">
    <!-- En-tête de la page -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 border-b border-light-gray/20 pb-4">
        <h1 class="text-2xl font-family-title font-weight-regular mb-2 md:mb-0">
            Cellier : <span class="color-taupe font-family">{{ $cellar->name }}</span>
        </h1>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
        @foreach ($cellar->cellarBottles as $cellarbottle)
        <a href="{{route('cellar_bottle.show', $cellarbottle->id)}}" class="bg-white border border-light-gray/20 rounded-lg shadow p-5 flex flex-col justify-between relative hover:shadow-md transition-all duration-300 hover:border-light-gray/40">
            <div class="flex flex-row gap-4 mb-4">
                <!-- Image -->
                <div class="flex-shrink-0">
                    @if ($cellarbottle->bottle->image)
                    <img src="{{ $cellarbottle->bottle->image }}" class="max-w-[100px] max-h-[150px] object-cover rounded-md" alt="{{ $cellarbottle->bottle->name }}">
                    @else
                    <div class="bg-gray-100 flex items-center justify-center rounded-md">
                    </div>
                    @endif
                </div>

                <!-- Information des bouteilles -->
                <div class="flex-grow">
                    <h2 class="xs:text-base sm:text-md md:text-lg uppercase mb-2">{{$cellarbottle->bottle->name}}</h2>
                    <div class="flex flex-col gap-1 text-sm text-gray-600">
                        <p>{{ $cellarbottle->bottle->country }}</p>
                        <p>{{ $cellarbottle->bottle->format }}</p>
                    </div>
                </div>
            </div>

            <!-- Information additionnelles -->
            <div class="border-t border-light-gray/20 pt-3 mt-2">
                <div class="grid grid-cols-2 gap-2 text-sm">
                    @if($cellarbottle->purchase_date)
                    <div>
                        <span class="text-gray-500 font-medium">Date d'achat:</span>
                        <p>{{ $cellarbottle->purchase_date }}</p>
                    </div>
                    @endif

                    @if($cellarbottle->storage_until)
                    <div>
                        <span class="text-gray-500 font-medium">Conservation:</span>
                        <p>{{$cellarbottle->storage_until}}</p>
                    </div>
                    @endif
                </div>

                @if($cellarbottle->notes)
                <div class="mt-2">
                    <span class="text-gray-500 font-medium">Notes:</span>
                    <p class="text-sm line-clamp-2">{{ $cellarbottle->notes }}</p>
                </div>
                @endif
            </div>
        </a>
        @endforeach
    </div>
    @if ($cellar->cellarBottles->isEmpty())
    <div class="bg-white border border-light-gray/20 rounded-lg shadow p-8 text-center">
        <p class="text-lg font-family color-light-gray mb-4">Ce cellier ne contient aucune bouteille.</p>
    </div>
    @else
    <button type="submit" class="bouton mt-0">Ajouter une bouteille</button>

</div>
@endif
</div>
@endsection