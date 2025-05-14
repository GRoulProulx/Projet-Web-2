@extends('layouts.app')
@section('title', 'Mon cellier')
@section('content')

<section class="my_cellar mx-auto">
    <!-- En-tête de la page -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <header>
            <h1 class="text-lg font-family-title ">
                Cellier : <span class="color-taupe font-family">{{ $cellar->name }}</span>
                <a href="{{route('cellar.edit', $cellar->id)}}"><i class="fa-regular fa-pen-to-square text-md text-taupe"></i></a>
                <input type="text" id="cellar_id" value="{{$cellar->id}}" class="hidden">
            </h1>
        </header>
        <div class="flex gap-xxs justify-between flex-wrap mt-sm mb-sm ">
            <a href="{{ route('bottle.index') }}" class="bouton mt-0 grow text-center"><i class="fa fa-plus mr-xs" aria-hidden="true"></i>Ajouter une bouteille</a>
            <button class="bouton alert mt-0 grow" data-action="delete">Supprimer le cellier</button>
        </div>
    </div>

    <!-- Bouteilles du cellier -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-sm mb-sm ">
        @foreach ($cellar->cellarBottles as $cellarBottle)
        <div class="border border-light-gray/20 rounded-lg shadow p-md flex flex-col gap-sm justify-between relative hover:shadow-md transition-all duration-300 hover:border-light-gray/40">
            <div class="flex flex-col sm:flex-row gap-sm text-sm">
                <!-- Image -->
                <div class="flex-shrink-0">
                    @if ($cellarBottle->bottle->image)
                    <img src="{{ $cellarBottle->bottle->image }}" class="mx-auto sm:mx-0 max-w-[100px] max-h-[150px] object-cover rounded-md" alt="{{ $cellarBottle->bottle->name }}">
                    @else
                    <div class="bg-gray-100 flex items-center justify-center rounded-md">
                    </div>
                    @endif
                </div>

                <!-- Information des bouteilles -->
                <div class="flex-grow ">
                    <h2 class="xs:text-base sm:text-base md:text-md uppercase mb-2">{{$cellarBottle->bottle->name}}</h2>
                    <div class="flex gap-xs flex-wrap">
                        <p>{{ $cellarBottle->bottle->type }}</p>
                        <div class="border-2 border-l border-light-gray"></div>
                        <p>{{ $cellarBottle->bottle->format }}</p>
                        <div class="border-2 border-l border-light-gray"></div>
                        <p>{{ $cellarBottle->bottle->country }}</p>
                    </div>
                </div>
            </div>

            <!-- Formulaire pour indiquée qu'une bouteille est bue -->
            <div class="flex justify-between items-baseline-last flex-wrap gap-sm">
                <form action="{{route('cellar_bottle.drink', $cellarBottle->id)}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="flex flex-col">
                        <label for="quantity" class="font-regular">Quantité: </label>
                        <div class="flex">
                            <input type="text" id="bottle_id" name="bottle_id" value="{{$cellarBottle->bottle->id}}" class="hidden">
                            <input type="number" id="quantity" name="quantity" min="1" max="{{$cellarBottle->quantity}}" value="{{$cellarBottle->quantity}}" class="border border-light-gray rounded-l-md rounded-r-none py-1 px-3 w-20 text-center">
                            <button type="submit" class="bouton py-1 px-3 text-sm rounded-r-md rounded-l-none sm:w-auto mt-0 sm:mt-0">Boire</button>
                        </div>
                    </div>
                </form>
                <a href="{{route('cellar_bottle.show', $cellarBottle->id)}}" class="w-fit text-md text-taupe link-underline-hover ">Détails <i class="fa-solid fa-circle-arrow-right text-base"></i></a>
            </div>

            <!-- Bordure grise -->
            <div class="border-t border-light-gray/20 ">
                <!-- Information additionnelles -->
                <div class="grid grid-cols-2 gap-2 text-sm mt-sm">
                    <div>
                        @if($cellarBottle->purchase_date == null)
                        <span class="text-gray-500 font-medium">Date d'achat:</span>
                        <p>-</p>
                        @else
                        <span class="text-gray-500 font-medium">Date d'achat:</span>
                        <p>{{ $cellarBottle->purchase_date }}</p>
                        @endif
                    </div>

                    <div>
                        @if($cellarBottle->storage_until == null)
                        <span class="text-gray-500 font-medium">Conservation:</span>
                        <p>-</p>
                        @else
                        <span class="text-gray-500 font-medium">Date d'achat:</span>
                        <p>{{ $cellarBottle->storage_until }}</p>
                        @endif
                    </div>
                </div>

                <div>
                    @if($cellarBottle->notes == null)
                    <span class="text-gray-500 font-medium">Notes:</span>
                    <p>-</p>
                    @else
                    <span class="text-gray-500 font-medium">Notes:</span>
                    <p>{{ $cellarBottle->notes }}</p>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <!-- Message si le cellier est vide -->
    @if ($cellar->cellarBottles->isEmpty())
    <div class="bg-white border border-light-gray/20 rounded-lg shadow p-8 text-center">
        <p class="text-lg font-family color-light-gray mb-4">Ce cellier ne contient aucune bouteille.</p>
    </div>
    @endif

    <!-- Section pour retourner aux celliers -->
    <div class="text-center mt-md">
        <a href="{{ route('cellar.index') }}" class="link-underline-hover"><i class="fa-solid fa-circle-arrow-left mr-2.5"></i>Retour à mes celliers</a>
    </div>
</section>

<!-- Modale -->
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