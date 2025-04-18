@extends('layouts.app')
@section('title', trans('Accueil'))
@section('content')

<section>
    <h1 class="font-family-title text-lg text-blue-magenta font-bold">
        Hello world!
    </h1>
    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quos nemo quidem obcaecati optio provident a architecto omnis! Nesciunt, excepturi? Assumenda quia similique ratione quasi optio consequatur doloribus libero hic expedita!</p>
</section>

<section class="mt-md">
    <header class="mb-xs">
        <h1 class="font-family-title text-lg text-taupe font-bold">
            Hello world!
        </h1>
    </header>
    <div class="flex flex-col gap-xxs">
        <h2 class="font-regular uppercase">Un sous-titre</h2>
        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quos nemo quidem obcaecati optio provident a architecto omnis! Nesciunt, excepturi? Assumenda quia similique ratione quasi optio consequatur doloribus libero hic expedita!</p>
    </div>
</section>

<button class="bouton">
    <span>Classe bouton</span>
</button>

<button class="bouton bouton-taupe">
    <span>Classe bouton</span>
</button>

<button class="bouton bouton-blue-magenta">
    <span>Classe bouton</span>
</button>

@endsection