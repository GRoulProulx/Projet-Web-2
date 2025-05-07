@extends('layouts.app')
@section('title', 'Mes Celliers')

@section('content')
<div class="container mx-auto py-6">

    <h1 class="text-xl text-center font-family-title font-weight-regular mb-6">Mes Celliers</h1>

    @if ($cellars->isEmpty())
    <div class="text-center mt-4">
        <p class="text-md color-light-gray font-family font-weight-regular spacing-sm">Vous n'avez pas encore de celliers.</p>
    </div>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-sm mb-10 mt-5">
        @foreach ($cellars as $cellar)
        <a href="{{ route('cellar.show', $cellar->id) }}" class="bg-white border border-light-gray/20 rounded-lg shadow p-5 flex flex-col justify-between relative hover:shadow-md transition-all duration-300 hover:border-light-gray/40">
            <h2 class="text-lg font-family-title font-weight-regular   mb-2 color--taupe uppercase ">{{ $cellar->name }}</h2>
            <p class="font-weight-medium font-family">Nombre de bouteilles :</p>
            <form method="POST" action="{{ route('cellar.destroy', $cellar->id) }}"
                onsubmit="return confirm('Supprimer ce cellier ?')"
                class="absolute top-2 right-2">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-white  px-2 py-1 rounded hover:bg-taupe/30 hover:text-md text-sm" title="Supprimer">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </form>
        </a>
        @endforeach
    </div>
    @endif
    <div class="text-center  mt-10">
        <a href="{{ route('cellar.create') }}" class="bouton">
            Ajouter un cellier
        </a>
    </div>
</div>
@endsection