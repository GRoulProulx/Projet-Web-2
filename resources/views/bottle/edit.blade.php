<section>
    <header>
        <h1>
            Modifier une bouteille
        </h1>
    </header>
    <form method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="name">Nom</label>
            <input type="text" id="name" name="name" value="{{old('name', $bottle->name)}}" required>
        </div>
        @if($errors->has('name'))
        <div>
            {{$errors->first('name')}}
        </div>
        @endif
        <div>
            <label for="image">Image</label>
            <input type="text" id="image" name="image" value="{{old('image', $bottle->image)}}" required>
        </div>
        @if($errors->has('image'))
        <div>
            {{$errors->first('image')}}
        </div>
        @endif
        <div>
            <label for="price">Prix</label>
            <input type="text" id="price" name="price" value="{{old('price', $bottle->price)}}">
        </div>
        @if($errors->has('price'))
        <div>
            {{$errors->first('price')}}
        </div>
        @endif
        <div>
            <label for="type">Type</label>
            <input type="text" id="type" name="type" value="{{old('type', $bottle->type)}}" required>
        </div>
        @if($errors->has('type'))
        <div>
            {{$errors->first('type')}}
        </div>
        @endif
        <div>
            <label for="format">Format</label>
            <input type="text" id="format" name="format" value="{{old('format', $bottle->format)}}" required>
        </div>
        @if($errors->has('format'))
        <div>
            {{$errors->first('format')}}
        </div>
        @endif
        <div>
            <label for="country">Pays</label>
            <input type="text" id="country" name="country" value="{{old('country', $bottle->country)}}" required>
        </div>
        @if($errors->has('country'))
        <div>
            {{$errors->first('country')}}
        </div>
        @endif
        <div>
            <label for="code_saq">Code SAQ</label>
            <input type="text" id="code_saq" name="code_saq" value="{{old('code_saq', $bottle->code_saq)}}" required>
        </div>
        @if($errors->has('code_saq'))
        <div>
            {{$errors->first('code_saq')}}
        </div>
        @endif
        <div>
            <label for="url">Lien SAQ</label>
            <input type="text" id="url" name="url" value="{{old('url', $bottle->url)}}" required>
        </div>
        @if($errors->has('url'))
        <div>
            {{$errors->first('url')}}
        </div>
        @endif

        <button type="submit">Sauvegarder</button>
        <a href="{{route('bottle.show', $bottle->id)}}">Annuler</a>
    </form>
</section>