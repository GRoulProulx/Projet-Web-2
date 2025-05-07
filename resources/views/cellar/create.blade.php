@extends('layouts.app')
@section('title', 'Créer un cellier')
@section('content')

<section class="md:max-w-3xl mx-auto">
    <header class="mb-md py-sm">
        <h1 class="font-family-title text-lg">Créer un cellier</h1>
    </header>
    <form method="POST" action="{{ route('cellar.store') }}" class="flex flex-col gap-sm ">
        @csrf
        <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Nom" aria-label="Nom" class="border border-light-gray/30 rounded-md p-xs">
        @if($errors->has('name'))
        <div class="border border-alert text-alert rounded-md p-xxs">
            {{$errors->first('name')}}
        </div>
        @endif

        <button type="submit" class="bouton mt-0">Sauvegarder</button>
        <!-- <a href="{{ route('cellar.index') }}" class="bouton white mt-0">Annuler</a> -->
    </form>
    <div class="text-center mt-md">
        <a href="{{ route('cellar.index') }}" class="link-underline-hover">Retour à mes celliers</a>
    </div>
</section>
@endsection