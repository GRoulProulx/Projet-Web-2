@extends('layouts.app')
@section('title', 'Modifier un cellier')
@section('content')

<section>
    <header class="mb-md text-center">
        <h1 class="font-family-title text-lg">Modifier un cellier</h1>
    </header>
    <form method="POST" class="flex flex-col gap-sm md:max-w-3xl mx-auto">
        @csrf
        @method('PUT')
        <input type="text" id="name" name="name" value="{{ old('name', $cellar->name) }}" placeholder="Nom" aria-label="Nom" class="border border-light-gray/30 rounded-md p-xs" required>
        @if($errors->has('name'))
        <div>
            {{$errors->first('name')}}
        </div>
        @endif

        <button type="submit" class="bouton mt-0">Sauvegarder</button>
        <!-- <a href="{{ route('cellar.index') }}" class="bouton white mt-0">Annuler</a> -->
    </form>
</section>
@endsection