@extends('layouts.app')
@section('title', 'Détails d\'un vin du cellier')
@section('content')

<section>
    <article class="mx-auto relative max-w-3xl border border-light-gray/30 rounded-md p-sm">
        <!-- <i class="fa-regular fa-heart absolute top-sm left-sm text-lg text-taupe"></i> -->
        <div class="flex gap-sm flex-wrap">
            <img src="{{$cellarBottle->bottle->image}}" alt="{{$cellarBottle->bottle->image}}" class="max-w-[111px] max-h-[166px] object-cover mx-auto">
            <div class="flex flex-col gap-sm">
                <header>
                    <h2 class="xs:text-base sm:text-md md:text-lg uppercase font-regular">{{$cellarBottle->bottle->name}}</h2>
                </header>
                <div class="flex gap-xs flex-wrap ">
                    <p>{{$cellarBottle->bottle->type}}</p>
                    <div class="border-2 border-l border-light-gray"></div>
                    <p>{{$cellarBottle->bottle->format}}</p>
                    <div class="border-2 border-l border-light-gray"></div>
                    <p>{{$cellarBottle->bottle->country}}</p>
                </div>
                <div class="flex flex-col">
                    <p><span class="font-regular">Date d'achat:</span> {{$cellarBottle->purchase_date}}</p>
                    <p><span class="font-regular">Garder jusqu'à:</span> {{$cellarBottle->storage_until}}</p>
                </div>
                <form action="" method="post">
                    @csrf
                    @method('PUT')
                    <div class="flex flex-col">
                        <label for="quantity" class="font-regular">Quantité: </label>
                        <div class="flex">
                            <input type="number" id="quantity" name="quantity" min="1" max="{{$cellarBottle->quantity}}" value="{{$cellarBottle->quantity}}" class="border border-light-gray rounded-l-md rounded-r-none py-1 px-3 w-20 text-center">
                            <button type="submit" class="bouton py-1 px-3  text-sm rounded-r-md rounded-l-none w- sm:w-auto mt-0 sm:mt-0">Boire</button>
                        </div>
                    </div>
                </form>

                <div class="flex flex-col">

                    <p><span class="font-regular">Prix d'achat:</span> {{$cellarBottle->price}} $</p>
                    <p><span class="font-regular">Note:</span> {{$cellarBottle->notes}}</p>

                </div>

                <a href="{{$cellarBottle->bottle->url}}" target="_blank" class="link-underline-hover max-w-fit">Commander à la SAQ <i class="fa-solid fa-arrow-up-right-from-square text-taupe"></i></a>
            </div>
        </div>
        <div class="mt-md flex gap-md flex-col align-center justify-items-center">
            <div class="flex gap-sm justify-between flex-wrap ">
                <a href="{{ route('cellar_bottle.edit', $cellarBottle->id)}}" class="bouton blue-magenta mt-0">Modifier</a>
                <form action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bouton alert mt-0">Supprimer</button>
                </form>
            </div>
        </div>
    </article>

    <div class="text-center mt-md">

    </div>


</section>

@endsection