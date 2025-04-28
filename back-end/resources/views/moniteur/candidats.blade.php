@extends('layouts.moniteur')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Mes candidats</h1>

    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form method="GET" action="{{ route('moniteur.candidats') }}">
            <div class="flex">
                <input type="text" name="search" placeholder="Rechercher un candidat..." 
                       value="{{ request('search') }}" class="flex-1 px-4 py-2 border rounded-l-lg focus:outline-none">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-r-lg hover:bg-blue-600">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type permis</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($candidats as $candidat)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $candidat->prenom }} {{ $candidat->nom }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $candidat->email }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $candidat->type_permis }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('moniteur.progression', $candidat) }}" 
                           class="text-blue-500 hover:text-blue-700">
                            Voir progression
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                        Aucun candidat trouvé
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $candidats->links() }}
    </div>
</div>
@endsection