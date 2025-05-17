@extends('layouts.app')
@section('title', trans('Liste des utilisateurs'))
@section('content')

<section>
    <div>
        <div class="mx-auto">
            <header class="max-w-5xl">
                <h1 class="font-family-title text-lg">Liste des utilisateurs</h1>
                <p>Consultez la liste des utilisateurs enregistrés sur la plateforme.</p>
            </header>

            <!-- Tableau des utilisateurs -->
            <div class="mt-md overflow-x-auto">
                <table class="min-w-full border border-light-gray/30 rounded-md">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-sm py-xs text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                            <th scope="col" class="px-sm py-xs text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th scope="col" class="px-sm py-xs text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date d'inscription</th>
                            <th scope="col" class="px-sm py-xs text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rôle</th>
                            <th scope="col" class="px-sm py-xs text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>

                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-light-gray/30">
                        @forelse($users as $user)

                        <tr class="hover:bg-gray-50 transition duration-300 ease-in-out">
                            <td class="px-sm py-xs whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="text-xs">{{ $user->name }}</div>
                                </div>
                            </td>
                            <td class="px-sm py-xs whitespace-nowrap">
                                <div class="text-xs">{{ $user->email }}</div>
                            </td>
                            <td class="px-sm py-xs whitespace-nowrap">
                                <div class="text-xs">{{ $user->created_at->format('d/m/Y') }}</div>
                            </td>
                            <td class="px-sm py-xs whitespace-nowrap">

                                @if($user->role_id == 1)
                                <span class="px-xxs py-xxs inline-flex text-xxs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Administrateur
                                </span>
                                @else
                                <span class="px-xxs py-xxs inline-flex text-xxs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    Utilisateur
                                </span>
                                @endif
                            </td>
                            <td class="px-sm py-xs whitespace-nowrap">
                                @if( !$user->role_id == 1 )
                                {{$user->id}}
                                <a href="#" data-action="delete" data-id="{{ $user->id }}" aria-label="Icône poubelle pour supprimer l'utilisateur"><i class="fa-solid fa-trash text-md text-alert"></i></a>
                                @endif
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-sm py-xs text-center text-xs">
                                Aucun utilisateur trouvé.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if(isset($users) && method_exists($users, 'links'))
            <div class="mt-md">
                {{ $users->links() }}
            </div>
            @endif
        </div>
    </div>
</section>
<!-- Modale -->
<div class="modale-container hidden relative z-10">
    <div class="modale fixed inset-0 bg-gray-500/75 transition-opacity">
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="modale-header flex items-start justify-between">
                            <h2 class="font-family-title text-lg uppercase">Supprimer l'usager</h2>
                            <a href=""><i class="fa-solid fa-xmark"></i></a>
                        </div>
                        <div class="modale-body">
                            <p>Êtes-vous sûr de vouloir supprimer cet usager?</p>
                        </div>
                        <div class="modale-footer flex justify-between items-baseline">
                            <a href="" class="bouton blue-magenta">Annuler</a>
                            <form action="" method="POST" id="deleteUserForm">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bouton alert mt-0" data-action="delete" data-id="{{ $user->id }}">Supprimer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection