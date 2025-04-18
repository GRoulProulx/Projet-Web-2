@extends('layouts.app')
@section('title', trans('Afficher une bouteille'))
@section('content')

<div>
    <header>
        <h1>Détails d'une bouteille</h1>
    </header>
    
    <table>
        <tr>
            <th>Identifiant</th>
            <td>{{ $bottle->id }}</td>
        </tr>
        <tr>
            <th>Nom</th>
            <td>{{ $bottle->name }}</td>
        </tr>
        <tr>
            <th>Image</th>
            <td>{{ $bottle->image }}</td>
        </tr>
        <tr>
        <tr>
            <th>Prix</th>
            <td>{{ $bottle->price }}</td>
        </tr>
        <tr>
            <th>Type</th>
            <td>{{ $bottle->type }}</td>
        </tr>
        <tr>
            <th>Format</th>
            <td>{{ $bottle->format }}</td>
        </tr>
        <tr>
            <th>Pays</th>
            <td>{{ $bottle->country }}</td>
        </tr>
        <tr>
            <th>Code SAQ</th>
            <td>{{ $bottle->code_saq }}</td>
        </tr>
        <tr>
            <th>Lien vers SAQ</th>
            <td>{{ $bottle->url }}</td>
        </tr>
    </table>

    <div>
        <a href="{{ route('bottle.index') }}">Retour à la liste</a>
    </div>
</div>

@endsection