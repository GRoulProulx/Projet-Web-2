@extends('layouts.app')
@section('title', 'Mes Celliers')

@section('content')
<div class="container mx-auto px-4 py-6">

    <h1 class="text-xl text-center font-family-title font-weight-regular mb-6">Mes Celliers</h1>

    @if ($cellars->isEmpty())
        <div class="text-center mt-4">
            <p class="text-md color-light-gray font-family font-weight-regular spacing-sm">Vous n'avez pas encore de celliers.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10 mt-5">
            @foreach ($cellars as $cellar)
                <div class="bg-white border border-light-gray/20 rounded-lg shadow p-4 flex flex-col justify-between relative transition-transform hover:scale-105 active:scale-105 focus:scale-105 hover:shadow-md active:shadow-md focus:shadow-md">
                    
                    <h2 class="text-xl font-family font-weight-medium  mb-2 color--taupe">{{ $cellar->name }}</h2>

                    <a href="{{ route('cellar.show', $cellar->id) }}"
                       class="text-md font-family text-taupe  mb-4 ">
                        Voir le cellier
                    </a>
                    <form method="POST" action="{{ route('cellar.destroy', $cellar->id) }}"
                          onsubmit="return confirm('Supprimer ce cellier ?')"
                          class="absolute top-2 right-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-white  px-2 py-1 rounded hover:bg-taupe/30 hover:text-md text-sm" title="Supprimer">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </div>
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