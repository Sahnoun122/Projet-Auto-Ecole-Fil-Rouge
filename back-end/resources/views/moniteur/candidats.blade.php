@extends('layouts.moniteur')
@section('title', 'Mes Candidats')
@section('content')
<div class="flex-1 overflow-auto p-4 md:p-6">
    <header class="bg-[#4D44B5] text-white shadow-md rounded-lg mb-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col md:flex-row justify-between items-center">
            <h1 class="text-2xl font-bold mb-2 md:mb-0">Gestion de Mes Candidats</h1>
        </div>
    </header>

    <main class="max-w-7xl mx-auto">
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="px-4 sm:px-6 py-4 border-b border-gray-200 flex flex-col md:flex-row justify-between items-center gap-4">
                <h2 class="text-xl font-semibold text-gray-800">Liste de Mes Candidats</h2>
                <form method="GET" action="{{ route('moniteur.candidats') }}" class="relative w-full md:w-auto">
                    <input type="text" name="search" placeholder="Rechercher..."
                           value="{{ request('search') }}"
                           class="pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] w-full">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Photo</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom & Prénom</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Email</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Permis</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($candidats as $candidat)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex-shrink-0 h-10 w-10">
                                    {{-- Assurez-vous que la variable $defaultProfilePic est définie ou utilisez asset() directement --}}
                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ $candidat->photo_profile ? asset('storage/'.$candidat->photo_profile) : asset('images/default-profile.png') }}" alt="Photo profil">
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $candidat->nom }} {{ $candidat->prenom }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap hidden md:table-cell">
                                <div class="text-sm text-gray-500">{{ $candidat->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-[#4D44B5] bg-opacity-80 text-white">
                                    {{ $candidat->type_permis }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('moniteur.progression', $candidat->id) }}" class="text-blue-500 hover:text-blue-700 flex items-center" title="Voir progression">
                                        <i class="fas fa-chart-line mr-1"></i> Progression
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                Aucun candidat assigné ou trouvé
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-4 sm:px-6 py-4 border-t border-gray-200">
                {{ $candidats->appends(['search' => request('search')])->links() }}
            </div>
        </div>
    </main>
</div>
@endsection