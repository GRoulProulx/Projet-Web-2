@extends('layouts.app')
@section('title', 'Mes Celliers')

@section('content')
<div class="container">

    <header class="mb-sm">
        <h1 class="text-lg font-family-title">Mes Celliers</h1>
    </header>

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
        </a>
        @endforeach
    </div>
    @endif
    <div class="text-center">
        <a href="{{ route('cellar.create') }}" class="bouton ">
            Ajouter un cellier
        </a>
    </div>
</div>
@endsection