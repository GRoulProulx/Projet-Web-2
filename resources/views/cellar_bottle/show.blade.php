@extends('layouts.app')
@section('title', 'Détails d\'un vin du cellier')
@section('content')

<section>
    <article class="mx-auto relative max-w-3xl border border-light-gray/30 rounded-md p-sm">
        <div class="flex gap-sm flex-wrap">
            <!-- Image -->
            <img src="{{$cellarBottle->bottle->image}}" alt="{{$cellarBottle->bottle->image}}" class="max-w-[111px] max-h-[166px] object-cover mx-auto">
            <div class="flex flex-col gap-sm">
                <!-- Entête -->
                <header>
                    <h2 class="xs:text-base sm:text-md md:text-lg uppercase font-regular">{{$cellarBottle->bottle->name}}</h2>
                </header>
                <!-- Informations générales -->
                <div class="flex gap-xs flex-wrap ">
                    <p>{{$cellarBottle->bottle->type}}</p>
                    <div class="border-2 border-l border-light-gray"></div>
                    <p>{{$cellarBottle->bottle->format}}</p>
                    <div class="border-2 border-l border-light-gray"></div>
                    <p>{{$cellarBottle->bottle->country}}</p>
                </div>
                <!-- Informations supplémentaires -->
                <div class="flex flex-col">
                    <p><span class="font-regular">Date d'achat:</span> {{$cellarBottle->purchase_date}}</p>
                    <p><span class="font-regular">Garder jusqu'à:</span> {{$cellarBottle->storage_until}}</p>
                </div>
                <div class="flex flex-col">
                    <p><span class="font-regular">Prix d'achat:</span> {{$cellarBottle->price}} $</p>
                    <p><span class="font-regular">Note:</span> {{$cellarBottle->notes}}</p>
                </div>
                <!-- Lien SAQ -->
                <a href="{{$cellarBottle->bottle->url}}" target="_blank" class="link-underline-hover max-w-fit">Commander à la SAQ <i class="fa-solid fa-arrow-up-right-from-square text-taupe"></i></a>
            </div>
        </div>
        <!-- Section pour modifier et supprimer -->
        <div class="mt-md flex gap-md flex-col align-center justify-items-center">
            <div class="flex gap-sm justify-between flex-wrap ">
                <a href="{{ route('cellar_bottle.edit', $cellarBottle->id)}}" class="bouton white mt-0">Modifier</a>
                <button class="bouton alert mt-0" data-action="delete">Supprimer</button>
            </div>
        </div>
    </article>

    <div class="text-center mt-md">
        <a href="{{ route('cellar.show', $cellarId) }}" class="link-underline-hover">Retour au cellier</a>
    </div>

    <!-- MODALE -->
    <div class="modale-container hidden relative z-10">
        <div class="modale fixed inset-0 bg-gray-500/75 transition-opacity">
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4 text-center sm:items-center sm:p-0">
                    <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="modale-header flex items-start justify-between">
                                <h2 class="font-family-title text-lg uppercase">Supprimer le vin</h2>
                                <a href="{{route('cellar_bottle.show', $cellarBottle->id)}}"><i class="fa-solid fa-xmark"></i></a>
                            </div>
                            <div class="modale-body">
                                <p>Êtes-vous sûr de vouloir supprimer ce vin de votre cellier?</p>
                            </div>
                            <div class="modale-footer flex justify-between items-baseline">
                                <a href="{{route('cellar_bottle.show', $cellarBottle->id)}}" class="bouton blue-magenta">Annuler</a>
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
</section>

@endsection