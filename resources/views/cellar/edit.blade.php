@extends('layouts.app')
@section('title', 'Modifier un cellier')
@section('content')

<section class="flex flex-col gap-sm md:max-w-3xl mx-auto">
    <header>
        <h1 class="font-family-title text-lg">Modifier un cellier</h1>
    </header>
    <!-- Formulaire pour modifier un cellier -->
    <form method="POST" class="flex flex-col gap-sm">
        @csrf
        @method('PUT')
        <input type="text" id="name" name="name" value="{{ old('name', $cellar->name) }}" placeholder="Nom" aria-label="Nom" class="border border-light-gray/30 rounded-md p-xs" required>
        @if($errors->has('name'))
        <div class="border border-alert text-alert rounded-md p-xxs">
            {{$errors->first('name')}}
        </div>
        @endif
        <button type="submit" class="bouton mt-0">Sauvegarder</button>
    </form>
    <div class="text-center mt-sm">
        <a href="{{ route('cellar.show', $cellar->id) }}" class="link-underline-hover inline-flex"><i class="fa-solid fa-circle-arrow-left mr-2.5"></i></p> Retour à mon cellier</a>
    </div>
</section>

@endsection