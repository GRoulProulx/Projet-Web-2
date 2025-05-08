@extends('layouts.app')
@section('title', 'Détails d\'un vin')
@section('content')

<section>
    <article class="mx-auto relative max-w-3xl border border-light-gray/30 rounded-md p-sm">
        <!-- <i class="fa-regular fa-heart absolute top-sm left-sm text-lg text-taupe"></i> -->
        <div class="flex gap-sm flex-wrap">
            <img src="{{ $bottle->image }}" alt="{{ $bottle->name }}" class="max-w-[111px] max-h-[166px] object-cover mx-auto">
            <div class="flex flex-col gap-xxs">
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
                <div class="flex flex-col gap-y-xs">
                    <p>{{ number_format($bottle->price, 2, ',', ' ') }}&nbsp;$</p>
                    <p>Code: {{ $bottle->code_saq}}</p>
                    <a href="{{ $bottle->url}}" target="_blank" class="link-underline-hover max-w-fit">Commander à la SAQ <i class="fa-solid fa-arrow-up-right-from-square text-taupe"></i></a>
                    @auth
                    @if(auth()->user()->role_id == null)
                    <div class="flex flex-col pt-md">

                        <form action="{{ route('cellar_bottle.store') }}" class="flex flex-col gap-xxs" method="POST">
                            @csrf
                            @if ($bottle)
                                <input type="hidden" name="bottle_id" value="{{ $bottle->id }}">
                            @endif

                            <div class="flex flex-col gap-xs">
                                <label for="quantity">Quantité</label>
                                <input aria-label="Ajouter à mon cellier" type="number" name="quantity" id="quantity" value="1" min="1" required class="border p-xs rounded-md">
                                <select name="cellar_id" id="cellar_name" required class="border p-xs rounded-md">
                                    <option value="">Choisir un cellier</option>
                                    @foreach ($cellars as $cellar)
                                    <option value="{{$cellar->id}}">{{$cellar->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="bouton">Ajouter à mon cellier</button>
                        </form>
                        </fieldset>
                    </div>
                    @endif
                    @endauth
                </div>
            </div>
        </div>
        @auth
        @if(auth()->user()->role_id == 1)
        <div class="mt-md flex gap-md flex-col align-center justify-items-center">
            <div class="flex gap-sm justify-between flex-wrap ">
                <a href="{{ route('bottle.edit', $bottle->id) }}" class="bouton blue-magenta mt-0">Modifier</a>
                <button class="bouton alert mt-0" data-action="delete">Supprimer</button>

                <!-- <form action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bouton alert mt-0">Supprimer</button>
                </form> -->
            </div>
        </div>
        @endif
        @endauth
    </article>
    <div class="text-center mt-md">
        <a href="{{ route('bottle.index') }}" class="link-underline-hover"><i class="fa-solid fa-circle-arrow-left mr-2.5"></i>Retour au catalogue des vins</a>
    </div>

    <!-- MODALE -->
    <div class="modale-container hidden relative z-10">
        <div class="modale fixed inset-0 bg-gray-500/75 transition-opacity">
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4 text-center sm:items-center sm:p-0">
                    <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="modale-header flex items-start justify-between">
                                <h2 class="font-family-title text-lg uppercase">Supprimer le vin</h2>
                                <a href="{{route('bottle.show', $bottle->id)}}"><i class="fa-solid fa-xmark"></i></a>
                            </div>
                            <div class="modale-body">
                                <p>Êtes-vous sûr de vouloir supprimer ce vin du catalogue?</p>
                            </div>
                            <div class="modale-footer flex justify-between items-baseline">
                                <a href="{{route('bottle.show', $bottle->id)}}" class="bouton blue-magenta">Annuler</a>
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