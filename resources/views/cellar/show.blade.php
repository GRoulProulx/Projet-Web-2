@extends('layouts.app')
@section('title', 'Cellier')
@section('content')

<div class="container">
    <!-- En-tête de la page -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <h1 class="text-lg font-family-title md:mb-0">
            Cellier : <span class="color-taupe font-family">{{ $cellar->name }}</span>
        </h1>
        <div class="flex gap-2 justify-between mt-sm mb-sm">
            <a href="{{ route('bottle.index') }}" class="bouton mt-0"><i class="fa fa-plus mr-xs" aria-hidden="true"></i>Vins du catalogue</a>
            <button class="bouton alert mt-0" data-action="delete">Supprimer le cellier</button>

            <!-- <a href="#" class="bouton white mt-0"><i class="fa fa-plus mr-xs" aria-hidden="true"></i>Importations privés</a> -->
        </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-sm mb-sm">
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
                <div class="flex-grow ">
                    <h2 class="xs:text-base sm:text-md md:text-lg uppercase mb-2">{{$cellarbottle->bottle->name}}</h2>
                    <div class="flex gap-xs flex-wrap">
                        <p>{{ $cellarbottle->bottle->type }}</p>
                        <div class="border-2 border-l border-light-gray"></div>
                        <p>{{ $cellarbottle->bottle->format }}</p>
                        <div class="border-2 border-l border-light-gray"></div>
                        <p>{{ $cellarbottle->bottle->country }}</p>
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
    @endif


    <a href="{{route('cellar.edit', $cellar->id)}}" class="bouton white block text-center">Modifier le cellier</a>
    <div class="text-center mt-md">
        <a href="{{ route('cellar.index') }}" class="link-underline-hover">Retour à mes celliers</a>
    </div>
</div>
<!-- MODALE -->
<div class="modale-container hidden relative z-10">
    <div class="modale fixed inset-0 bg-gray-500/75 transition-opacity">
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="modale-header flex items-start justify-between">
                            <h2 class="font-family-title text-lg uppercase">Supprimer le cellier</h2>
                            <a href=""><i class="fa-solid fa-xmark"></i></a>
                        </div>
                        <div class="modale-body">
                            <p>Êtes-vous sûr de vouloir supprimer ce cellier?</p>
                        </div>
                        <div class="modale-footer flex justify-between items-baseline">
                            <a href="" class="bouton blue-magenta">Annuler</a>


                            <form action="" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bouton alert mt-0" data-action="delete">Supprimer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection