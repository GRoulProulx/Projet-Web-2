<section>
    <header>
        <h1>Liste des bouteilles</h1>
    </header>
    <table>
        <thead>
            <tr>
                <th>Identifiant</th>
                <th>Nom</th>
                <th>Image</th>
                <th>Prix</th>
                <th>Type</th>
                <th>Format</th>
                <th>Pays</th>
                <th>Code SAQ</th>
                <th>Lien vers SAQ</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bottles as $bottle)
            <tr>
                <td>{{ $bottle->id }}</td>
                <td>{{ $bottle->name }}</td>
                <td>{{ $bottle->image }}</td>
                <td>{{ $bottle->price }}</td>
                <td>{{ $bottle->type }}</td>
                <td>{{ $bottle->format }}</td>
                <td>{{ $bottle->country }}</td>
                <td>{{ $bottle->code_saq }}</td>
                <td>{{ $bottle->url }}</td>

                <td>
                    <a href="{{ route('bottle.show', $bottle->id) }}">Voir</a>
                    <a href="{{ route('bottle.edit', $bottle->id) }}">Modifier</a>
                    <form action="{{ route('bottle.destroy', $bottle->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div>
        <a href="{{ route('bottle.create') }}">Ajouter une bouteille</a>
    </div>
</section>