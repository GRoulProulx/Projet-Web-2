@extends('layouts.app')
@section('title', 'Ajouter un vin au cellier')
@section('content')

<section>
    <header class="mb-md text-center">
        <h1 class="font-family-title text-lg">Ajouter une bouteille au cellier</h1>
    </header>
    <form method="POST" action="{{ route('cellar_bottle.store') }}" class="flex flex-col gap-sm md:max-w-3xl mx-auto">
        @csrf

        <div class="flex flex-col gap-xxs">
            <label for="bottle_id">Sélectionner une bouteille</label>
            <select id="bottle_id" name="bottle_id" class="border border-light-gray/30 rounded-md p-xs" required>
                <option value="">Sélectionner une bouteille</option>
                @foreach($bottles as $bottle)
                <option value="{{ $bottle->id }}" {{ old('bottle_id') == $bottle->id ? 'selected' : '' }}>
                    {{ $bottle->name }}
                </option>
                @endforeach
            </select>
            @if($errors->has('bottle_id'))
            <div class="text-red-500 text-xs">
                {{$errors->first('bottle_id')}}
            </div>
            @endif
        </div>

        <div class="flex flex-col gap-xxs">
            <label for="purchase_date">Date d'achat</label>
            <input type="date" id="purchase_date" name="purchase_date" value="{{ old('purchase_date') }}" class="border border-light-gray/30 rounded-md p-xs" required>
            @if($errors->has('purchase_date'))
            <div class="text-red-500 text-xs">
                {{$errors->first('purchase_date')}}
            </div>
            @endif
        </div>

        <div class="flex flex-col gap-xxs">
            <label for="storage_until">Garder jusqu'à</label>
            <input type="date" id="storage_until" name="storage_until" value="{{ old('storage_until') }}" class="border border-light-gray/30 rounded-md p-xs" required>
            @if($errors->has('storage_until'))
            <div class="text-red-500 text-xs">
                {{$errors->first('storage_until')}}
            </div>
            @endif
        </div>

        <div class="flex flex-col gap-xxs">
            <label for="price">Prix</label>
            <input type="number" id="price" name="price" step="0.01" value="{{ old('price') }}" placeholder="Prix" aria-label="Prix" class="border border-light-gray/30 rounded-md p-xs" required>
            @if($errors->has('price'))
            <div class="text-red-500 text-xs">
                {{$errors->first('price')}}
            </div>
            @endif
        </div>

        <div class="flex flex-col gap-xxs">
            <label for="quantity">Quantité</label>
            <input type="number" id="quantity" name="quantity" value="{{ old('quantity', 1) }}" placeholder="Quantité" aria-label="Quantité" class="border border-light-gray/30 rounded-md p-xs" required>
            @if($errors->has('quantity'))
            <div class="text-red-500 text-xs">
                {{$errors->first('quantity')}}
            </div>
            @endif
        </div>

        <div class="flex flex-col gap-xxs">
            <label for="vintage">Millésime</label>
            <input type="number" id="vintage" name="vintage" value="{{ old('vintage') }}" placeholder="Millésime" aria-label="Millésime" class="border border-light-gray/30 rounded-md p-xs">
            @if($errors->has('vintage'))
            <div class="text-red-500 text-xs">
                {{$errors->first('vintage')}}
            </div>
            @endif
        </div>

        <div class="flex flex-col gap-xxs">
            <label for="notes">Notes</label>
            <textarea id="notes" name="notes" placeholder="Notes" aria-label="Notes" class="border border-light-gray/30 rounded-md p-xs">{{ old('notes') }}</textarea>
            @if($errors->has('notes'))
            <div class="text-red-500 text-xs">
                {{$errors->first('notes')}}
            </div>
            @endif
        </div>

        <div class="flex gap-sm mt-md">
            <button type="submit" class="bouton mt-0 flex-1">Ajouter au cellier</button>
            <a href="{{ route('cellar.index') }}" class="bouton white mt-0 flex-1 text-center">Annuler</a>
        </div>
    </form>
</section>
@endsection