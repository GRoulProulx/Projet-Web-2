@extends('layouts.app')

@section('title', 'Ajouter une bouteille personnalisée')

@section('content')
<section>
    <header class="mb-md text-center">
        <h1 class="font-family-titlw text-lg">Ajouter une bouteille personnalisée</h1>
    </header>

    <form method="POST" action="{{ route('custom-bottles.store') }}" enctype="multipart/form-data" class="flex flex-col gap-sm md:max-w-3xl mx-auto">
        @csrf

        <input type="text" name="name" placeholder="Nom" value="{{ old('name') }}" class="border p-xs rounded-md">
        @error('name') <div class="text-alert">{{ $message }}</div> @enderror

        <!-- Image de la bouteille-->
        <label class="font-family">Image de la bouteille</label>
        <input type="file" name="image" accept="image/*" class="border p-xs rounded-md">
        @error('image') <div class="text-alert">{{ $message }}</div> @enderror

        <!-- Valeur de secours si l'image est vide -->
        <input type="hidden" name="default_image" value="{{ asset('images/bouteille-par-defaut.jpg') }}">

        <input type="number" step="0.01" name="price" placeholder="Prix" value="{{ old('price') }}" class="border p-xs rounded-md">
        @error('price') <div class="text-alert">{{ $message }}</div> @enderror

        <select name="type" id="type-select" class="border p-xs rounded-md">
            <option value="">Sélectionnez un type</option>
            <option value="Vin rouge" {{ old('type') == 'Vin rouge' ? 'selected' : '' }}>Vin rouge</option>
            <option value="Vin blanc" {{ old('type') == 'Vin blanc' ? 'selected' : '' }}>Vin blanc</option>
            <option value="Vin rosé" {{ old('type') == 'Vin rosé' ? 'selected' : '' }}>Vin rosé</option>
            <option value="Autre" {{ old('type') && !in_array(old('type'), ['Vin rouge', 'Vin blanc', 'Vin rosé']) ? 'selected' : '' }}>Autre</option>
        </select>

        <input type="text" name="format" placeholder="Format" value="{{ old('format') }}" class="border p-xs rounded-md">
        <input type="text" name="country" placeholder="Pays" value="{{ old('country') }}" class="border p-xs rounded-md">

        <select name="cellar_id" class="border p-xs rounded-md" id="select_name_cellar">
            <option value="">Sélectionnez un cellier</option>
            @foreach ($cellars as $cellar)
            <option value="{{ $cellar->id }}">{{ $cellar->name }}</option>
            @endforeach
        </select>
        @error('cellar_id') <div class="text-alert">{{ $message }}</div> @enderror

        <input type="number" name="quantity" placeholder="Quantité" min="1" value="{{ old('quantity', 1) }}" class="border p-xs rounded-md">
        @error('quantity') <div class="text-alert">{{ $message }}</div> @enderror

        <button type="submit" class="bouton mt-0">Sauvegarder</button>
        <a href="{{ route('bottle.index') }}" class="bouton white mt-0 text-center">Annuler</a>
    </form>
</section>
@endsection