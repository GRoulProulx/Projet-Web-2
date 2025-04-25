@extends('layouts.app')
@section('title', 'Modifier une bouteille')
@section('content')
<section>
    <header class="mb-md text-center">
        <h1 class="font-family-title text-lg">
            Modifier une bouteille
        </h1>
    </header>
    <form method="POST" class="flex flex-col gap-sm md:max-w-3xl mx-auto">
        @csrf
        @method('PUT')
        <div class="flex flex-col gap-xxs">
            <label for="name">Nom</label>
            <input type="text" id="name" name="name" value="{{ old('name', $bottle->name) }}" placeholder="Nom" aria-label="Nom" class="border border-light-gray/30 rounded-md p-xs" required>
            @if($errors->has('name'))
            <div>
                {{$errors->first('name')}}
            </div>
            @endif
        </div>

        <div class="flex flex-col gap-xxs">
            <label for="image">Image</label>
            <input type="text" id="image" name="image" value="{{ old('image', $bottle->image) }}" placeholder="Image" aria-label="Image" class="border border-light-gray/30 rounded-md p-xs" required>
            @if($errors->has('image'))
            <div>
                {{$errors->first('image')}}
            </div>
            @endif
        </div>

        <div class="flex flex-col gap-xxs">
            <label for="price">Prix</label>
            <input type="text" id="price" name="price" value="{{ old('price', $bottle->price) }}$" placeholder="Prix" aria-label="Prix" class="border border-light-gray/30 rounded-md p-xs" required>
            @if($errors->has('price'))
            <div>
                {{$errors->first('price')}}
            </div>
            @endif
        </div>

        <div class="flex flex-col gap-xxs">
            <label for="type">Type</label>
            <input type="text" id="type" name="type" value="{{ old('type', $bottle->type) }}" placeholder="Type" aria-label="Type" class="border border-light-gray/30 rounded-md p-xs" required>
            @if($errors->has('type'))
            <div>
                {{$errors->first('type')}}
            </div>
            @endif
        </div>

        <div class="flex flex-col gap-xxs">
            <label for="format">Format</label>
            <input type="text" id="format" name="format" value="{{ old('format', $bottle->format) }}" placeholder="Format" aria-label="Format" class="border border-light-gray/30 rounded-md p-xs" required>
            @if($errors->has('format'))
            <div>
                {{$errors->first('format')}}
            </div>
            @endif
        </div>

        <div class="flex flex-col gap-xxs">
            <label for="country">Pays</label>
            <input type="text" id="country" name="country" value="{{ old('country', $bottle->country) }}" placeholder="Pays" aria-label="Pays" class="border border-light-gray/30 rounded-md p-xs" required>
            @if($errors->has('country'))
            <div>
                {{$errors->first('country')}}
            </div>
            @endif
        </div>

        <div class="flex flex-col gap-xxs">
            <label for="code_saq">Code SAQ</label>
            <input type="text" id="code_saq" name="code_saq" value="{{ old('code_saq', $bottle->code_saq) }}" placeholder="Code SAQ" aria-label="Code SAQ" class="border border-light-gray/30 rounded-md p-xs" required>
            @if($errors->has('code_saq'))
            <div>
                {{$errors->first('code_saq')}}
            </div>
            @endif
        </div>

        <div class="flex flex-col gap-xxs">
            <label for="url">Lien SAQ</label>
            <input type="text" id="url" name="url" value="{{ old('url', $bottle->url) }}" placeholder="Lien SAQ" aria-label="Lien SAQ" class="border border-light-gray/30 rounded-md p-xs" required>
            @if($errors->has('url'))
            <div>
                {{$errors->first('url')}}
            </div>
            @endif
        </div>

            <button type="submit" class="bouton mt-0">Sauvegarder</button>
            <a href="{{ route('bottle.index') }}" class="bouton white mt-0">Annuler</a>
    </form>
</section>
@endsection