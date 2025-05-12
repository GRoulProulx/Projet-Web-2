@extends('layouts.app')
@section('title', 'Inscription')
@section('content')

<!-- Page de d'inscription -->

<div class="border border-light-gray/30 p-md rounded-sm flex flex-col gap-sm md:max-w-3xl mx-auto">
    <div>
        <h2 class="font-family-title mx-2 text-lg">S'inscrire</h2>
        <form method="post" action="{{ route('user.store') }}">
            @csrf
            <div class="p-xxs">
                <input type="text" name="name" placeholder="Nom"
                    class="border border-light-gray/30 w-full p-xxs my-2 rounded-md focus:outline-none focus:light-gray bg-white" value="{{old('name')}}" required />
                @if($errors->has('name'))
                <div class="border border-alert text-alert rounded-md p-xxs">
                    {{$errors->first('name')}}
                </div>
                @endif
                <input type="email" name="email" placeholder="Courriel"
                    class="border border-light-gray/30 w-full p-xxs my-2 rounded-md focus:outline-none focus:light-gray bg-white" value="{{old('email')}}" required />
                @if($errors->has('email'))
                <div class="border border-alert text-alert rounded-md p-xxs">
                    {{$errors->first('email')}}
                </div>
                @endif
                <input type="password" name="password" placeholder="Mot de passe"
                    class="border border-light-gray/30 w-full p-xxs my-2 rounded-md focus:outline-none focus:light-gray bg-white" required />
                @if($errors->has('password'))
                <div class="border border-alert text-alert rounded-md p-xxs">
                    {{$errors->first('password')}}
                </div>
                @endif
            </div>

            <div class="hidden flex p-xs">
                <input type="checkbox" name="terms" class="mr-3" />
                <p class="text-xxs font-light">J'accepte les <span class="font-regular text-">Termes & Politiques de confidentialité</span></p>
                @if($errors->has('terms'))
                <div>
                    {{$errors->first('terms')}}
                </div>
                @endif
            </div>

            <div class="hidden relative flex items-center py-5">
                <div class="flex-grow border-t border-gray-300"></div>
                <span class="flex-shrink mx-4 text-xxs text-gray-500">Continuer avec</span>
                <div class="flex-grow border-t border-gray-300"></div>
            </div>

            <div class="hidden p-xxs flex-col justify-between">
                <button type="button" class="text-xxs w-full p-xs my-2 border border-light-gray/30 rounded-md focus:outline-none focus:light-gray bg-white cursor-pointer flex items-center justify-center">
                    <i class="fab fa-facebook mr-2"></i> Facebook
                </button>
                <button type="button" class="text-xxs w-full p-xs my-2 border border-light-gray/30 rounded-md focus:outline-none focus:light-gray bg-white cursor-pointer flex items-center justify-center">
                    <i class="fab fa-google mr-2"></i> Google
                </button>
                <button type="button" class="text-xxs w-full p-xs my-2 border border-light-gray/30 rounded-md focus:outline-none focus:light-gray bg-white cursor-pointer flex items-center justify-center">
                    <i class="fab fa-apple mr-2"></i> Apple
                </button>
            </div>

            <button type="submit" class="bouton w-full">S'inscrire</button>
        </form>

        <div class="mt-sm">
            <p class="text-xxs text-center">
                Déjà membre? <a href="{{ route('login') }}" class="underline"> Connectez-vous</a>
            </p>
        </div>
    </div>
</div>
@endsection