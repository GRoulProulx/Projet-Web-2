@extends('layouts.app')
@section('title', 'Mes Celliers')

@section('content')
<section class="mx-auto">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <header>
            <h1 class="text-lg font-family-title">Mes Celliers</h1>
        </header>
        <div class="flex gap-xxs justify-between flex-wrap mt-sm mb-sm">
            <a href="{{ route('cellar.create') }}" class="bouton mt-0 grow text-center "><i class="fa fa-plus mr-xs" aria-hidden="true"></i>
                Ajouter un cellier
            </a>
        </div>
    </div>

    @if ($cellars->isEmpty())
    <div class="bg-white border border-light-gray/20 rounded-lg shadow p-8 text-center mb-xl">
        <p class="text-lg font-family color-light-gray mb-4">Vous n'avez pas encore de celliers.</p>
    </div>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-sm mb-xl mt-md">
        @foreach ($cellars as $cellar)
        <a href="{{ route('cellar.show', $cellar->id) }}" class="bg-white border border-light-gray/20 rounded-lg shadow p-5 flex flex-col justify-between relative hover:shadow-md transition-all duration-300 hover:border-light-gray/40">
            <h2 class="text-md font-family-title font-weight-regular   mb-2 color--taupe uppercase ">{{ $cellar->name }}</h2>
            <p class="hidden font-weight-medium font-family">Nombre de bouteilles :</p>
            <p class="w-fit text-md text-taupe link-underline-hover ">Voir <i class="ri-arrow-right-circle-fill"></i></p>
            <form method="POST" action="{{ route('cellar.destroy', $cellar->id) }}"
                onsubmit="return confirm('Supprimer ce cellier ?')"
                class="absolute top-2 right-2">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-white  px-2 py-1 rounded hover:bg-taupe/30 hover:text-md text-sm" title="Supprimer">
                </button>
            </form>
        </a>
        @endforeach
    </div>
    @endif

</section>
@endsection