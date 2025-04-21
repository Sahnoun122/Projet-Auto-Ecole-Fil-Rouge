@extends('layouts.candidats')

@section('content')
<div class="w-full">
    <header class="bg-[#4D44B5] text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <h1 class="text-xl sm:text-2xl font-bold">Mes Cours de Conduite</h1>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @if(session('success'))
            <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="px-4 sm:px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg sm:text-xl font-semibold text-gray-800">Planning des Cours</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-xs sm:text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 sm:px-4 sm:py-3 text-left font-medium text-gray-500 uppercase tracking-wider text-xs">Date/Heure</th>
                            <th class="px-3 py-2 sm:px-4 sm:py-3 text-left font-medium text-gray-500 uppercase tracking-wider text-xs">Durée</th>
                            <th class="px-3 py-2 sm:px-4 sm:py-3 text-left font-medium text-gray-500 uppercase tracking-wider text-xs ">Moniteur</th>
                            <th class="px-3 py-2 sm:px-4 sm:py-3 text-left font-medium text-gray-500 uppercase tracking-wider text-xs ">Véhicule</th>
                            <th class="px-3 py-2 sm:px-4 sm:py-3 text-left font-medium text-gray-500 uppercase tracking-wider text-xs">Statut</th>
                            <th class="px-3 py-2 sm:px-4 sm:py-3 text-left font-medium text-gray-500 uppercase tracking-wider text-xs">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($cours as $cour)
                        <tr>
                            <td class="px-3 py-2 sm:px-4 sm:py-4 whitespace-nowrap">
                                {{ $cour->date_heure }}
                            </td>
                            <td class="px-3 py-2 sm:px-4 sm:py-4 whitespace-nowrap">
                                {{ $cour->duree_minutes }} min
                            </td>
                            <td class="px-3 py-2 sm:px-4 sm:py-4 whitespace-nowrap hidden sm:table-cell">
                                {{ $cour->moniteur->nom }} {{ $cour->moniteur->prenom }}
                            </td>
                            <td class="px-3 py-2 sm:px-4 sm:py-4 whitespace-nowrap hidden md:table-cell">
                                @if($cour->vehicule)
                                    {{ $cour->vehicule->marque }} ({{ $cour->vehicule->immatriculation }})
                                @else
                                    <span class="text-red-500">Non assigné</span>
                                @endif
                            </td>
                            <td class="px-3 py-2 sm:px-4 sm:py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs rounded-full 
                                    @if($cour->statut === 'planifie') bg-blue-100 text-blue-800
                                    @elseif($cour->statut === 'termine') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($cour->statut) }}
                                </span>
                            </td>
                            <td class="px-3 py-2 sm:px-4 sm:py-4 whitespace-nowrap text-sm font-medium">
                                <button onclick="showCourseDetails({{ $cour->id }})" 
                                    class="text-[#4D44B5] hover:text-[#3a32a1] px-2 py-1 bg-[#4D44B5]/10 rounded text-xs sm:text-sm">
                                    <i class="fas fa-eye mr-1"></i>Détails
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                Aucun cours programmé
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-4 py-2">
                    {{ $cours->links() }}
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Details Modal -->
<div id="detailsModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50 p-4">
    <div class="bg-white w-full max-w-md rounded-lg shadow-xl overflow-hidden">
        <div class="px-4 sm:px-6 py-4 border-b border-gray-200 bg-[#4D44B5] text-white">
            <h2 class="text-lg font-bold">Détails du Cours</h2>
            <button onclick="closeDetailsModal()" class="absolute top-3 right-3 text-white hover:text-gray-200">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="p-4 sm:p-6">
            <div id="modalLoading" class="flex justify-center py-8">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-[#4D44B5]"></div>
            </div>

            <div id="modalContent" class="hidden space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <h3 class="font-medium text-gray-700">Date/Heure</h3>
                        <p id="modalDate" class="text-gray-900"></p>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-700">Durée</h3>
                        <p id="modalDuree" class="text-gray-900"></p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <h3 class="font-medium text-gray-700">Moniteur</h3>
                        <p id="modalMoniteur" class="text-gray-900"></p>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-700">Véhicule</h3>
                        <p id="modalVehicule" class="text-gray-900"></p>
                    </div>
                </div>

                <div>
                    <h3 class="font-medium text-gray-700">Statut</h3>
                    <p id="modalStatut" class="text-gray-900"></p>
                </div>

                <div id="notesSection" class="hidden">
                    <h3 class="font-medium text-gray-700">Notes du Moniteur</h3>
                    <div id="modalNotes" class="bg-gray-50 p-3 rounded-lg mt-1"></div>
                </div>

                <div id="otherCandidatesSection" class="hidden">
                    <h3 class="font-medium text-gray-700">Autres Candidats</h3>
                    <div id="modalCandidates" class="space-y-2 mt-2"></div>
                </div>
            </div>
        </div>

        <div class="px-4 sm:px-6 py-4 border-t border-gray-200 flex justify-end">
            <button onclick="closeDetailsModal()" 
                class="px-4 py-2 bg-[#4D44B5] text-white rounded-lg hover:bg-[#3a32a1] transition">
                Fermer
            </button>
        </div>
    </div>
</div>

<script>

@endsection