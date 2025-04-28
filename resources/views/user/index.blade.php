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
                            <th scope="col" class="px-sm py-xs text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
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
                                <span class="px-xxs py-xxs inline-flex text-xxs leading-5 font-semibold rounded-full {{ $user->email_verified_at ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $user->email_verified_at ? 'Vérifié' : 'Non vérifié' }}
                                </span>
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

@endsection