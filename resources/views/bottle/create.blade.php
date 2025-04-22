@extends('layouts.app')
@section('title', trans('Ajouter une bouteille'))
@section('content')

<section>
    <header class="mb-md text-center">
        <h1 class="font-family-title text-lg">Ajouter une bouteille</h1>
    </header>
    <form method="POST" action="{{ route('bottle.store') }}" class="flex flex-col gap-sm md:max-w-3xl mx-auto">
        @csrf
        <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Nom" aria-label="Nom" class="border border-light-gray/30 rounded-md p-xs" required>
        @if($errors->has('name'))
        <div>
            {{$errors->first('name')}}
        </div>
        @endif

        <input type="text" id="image" name="image" value="{{ old('image') }}" placeholder="Image" aria-label="Image" class="border border-light-gray/30 rounded-md p-xs" required>
        @if($errors->has('image'))
        <div>
            {{$errors->first('image')}}
        </div>
        @endif

        <input type="text" id="price" name="price" value="{{ old('price') }}" placeholder="Prix" aria-label="Prix" class="border border-light-gray/30 rounded-md p-xs" required>
        @if($errors->has('price'))
        <div>
            {{$errors->first('price')}}
        </div>
        @endif

        <input type="text" id="type" name="type" value="{{ old('type') }}" placeholder="Type" aria-label="Type" class="border border-light-gray/30 rounded-md p-xs" required>
        @if($errors->has('type'))
        <div>
            {{$errors->first('type')}}
        </div>
        @endif

        <input type="text" id="format" name="format" value="{{ old('format') }}" placeholder="Format" aria-label="Format" class="border border-light-gray/30 rounded-md p-xs" required>
        @if($errors->has('format'))
        <div>
            {{$errors->first('format')}}
        </div>
        @endif

        <input type="text" id="country" name="country" value="{{ old('country') }}" placeholder="Pays" aria-label="Pays" class="border border-light-gray/30 rounded-md p-xs" required>
        @if($errors->has('country'))
        <div>
            {{$errors->first('country')}}
        </div>
        @endif

        <input type="text" id="code_saq" name="code_saq" value="{{ old('code_saq') }}" placeholder="Code SAQ" aria-label="Code SAQ" class="border border-light-gray/30 rounded-md p-xs" required>
        @if($errors->has('code_saq'))
        <div>
            {{$errors->first('code_saq')}}
        </div>
        @endif

        <input type="text" id="url" name="url" value="{{ old('url') }}" placeholder="Lien SAQ" aria-label="Lien SAQ" class="border border-light-gray/30 rounded-md p-xs" required>
        @if($errors->has('url'))
        <div>
            {{$errors->first('url')}}
        </div>
        @endif

        <button type="submit" class="bouton mt-0">Sauvegarder</button>
        <a href="{{ route('bottle.index') }}" class="bouton white mt-0">Annuler</a>
    </form>
</section>
@endsection