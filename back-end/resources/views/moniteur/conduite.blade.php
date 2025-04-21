@extends('layouts.moniteur')

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

        <div class="bg-white rounded-xl shadow overflow-hidden mb-8">
            <div class="px-4 sm:px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg sm:text-xl font-semibold text-gray-800">Cours Planifiés</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-xs sm:text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 sm:px-4 sm:py-3 text-left font-medium text-gray-500 uppercase tracking-wider text-xs">Date/Heure</th>
                            <th class="px-3 py-2 sm:px-4 sm:py-3 text-left font-medium text-gray-500 uppercase tracking-wider text-xs">Durée</th>
                            <th class="px-3 py-2 sm:px-4 sm:py-3 text-left font-medium text-gray-500 uppercase tracking-wider text-xs hidden sm:table-cell">Véhicule</th>
                            <th class="px-3 py-2 sm:px-4 sm:py-3 text-left font-medium text-gray-500 uppercase tracking-wider text-xs">Candidats</th>
                            <th class="px-3 py-2 sm:px-4 sm:py-3 text-left font-medium text-gray-500 uppercase tracking-wider text-xs">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($cours as $cour)
                        <tr data-course-id="{{ $cour->id }}">
                            <td class="px-3 py-2 sm:px-4 sm:py-4 whitespace-nowrap">
                                {{ $cour->date_heure}}
                            </td>
                            <td class="px-3 py-2 sm:px-4 sm:py-4 whitespace-nowrap">
                                {{ $cour->duree_minutes }} min
                            </td>
                            <td class="px-3 py-2 sm:px-4 sm:py-4 whitespace-nowrap hidden sm:table-cell">
                                @if($cour->vehicule)
                                    {{ $cour->vehicule->marque }} ({{ $cour->vehicule->immatriculation }})
                                @else
                                    <span class="text-red-500">Non assigné</span>
                                @endif
                            </td>
                            <td class="px-3 py-2 sm:px-4 sm:py-4">
                                <div class="flex flex-wrap gap-1">
                                    @if($cour->candidat)
                                        <span class="text-gray-800 px-1 py-0.5 sm:px-2 sm:py-1 rounded text-xs">
                                            {{ $cour->candidat->nom }} {{ $cour->candidat->prenom }}
                                        </span>
                                    @endif
                            
                                    @foreach($cour->candidats as $candidat)
                                        @if(!$cour->candidat || $candidat->id != $cour->candidat_id)
                                            <span class="text-gray-800 px-1 py-0.5 sm:px-2 sm:py-1 rounded text-xs">
                                                {{ $candidat->nom }} {{ $candidat->prenom }}
                                            </span>
                                        @endif
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-3 py-2 sm:px-4 sm:py-4 whitespace-nowrap text-sm font-medium">
                                <button class="show-presence-btn text-[#4D44B5] hover:text-[#3a32a1] px-2 py-1 bg-[#4D44B5]/10 rounded text-xs sm:text-sm"
                                    data-course-id="{{ $cour->id }}"
                                    data-course-date="{{ $cour->date_heure }}">
                                    <i class="fas fa-user-check mr-1"></i>Présence
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                Aucun cours planifié
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

<!-- Presence Modal Template -->
<div id="presenceModalTemplate" style="display: none;">
    <div class="bg-white w-full max-w-md rounded-lg shadow-xl overflow-hidden">
        <div class="px-4 sm:px-6 py-4 border-b border-gray-200 bg-[#4D44B5] text-white">
            <h2 class="text-lg font-bold">Gestion des Présences</h2>
            <p class="course-date text-sm opacity-90 mt-1"></p>
        </div>

        <form class="presence-form" method="POST" action="">
            @csrf
            <div class="p-4 sm:p-6 space-y-4 max-h-[60vh] overflow-y-auto">
                <!-- Candidat Principal -->
                <div class="border rounded-lg p-4 bg-gray-50">
                    <h3 class="font-medium text-lg mb-3">Candidat Principal</h3>
                    <div class="candidate-presence flex items-center justify-between mb-3">
                        <span class="candidate-name"></span>
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="present[]" value="" 
                                class="rounded border-gray-300 text-[#4D44B5] focus:ring-[#4D44B5]">
                            <span class="ml-2">Présent</span>
                        </label>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                        <textarea name="notes[]" rows="2" 
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]"></textarea>
                    </div>
                </div>

                <!-- Autres Candidats -->
                <div class="other-candidates-container border rounded-lg p-4 bg-gray-50">
                    <h3 class="font-medium text-lg mb-3">Autres Candidats</h3>
                    <div class="other-candidates space-y-4">
                        <!-- Dynamically filled -->
                    </div>
                </div>
            </div>

            <div class="px-4 sm:px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                <button type="button" class="cancel-presence-btn px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                    Annuler
                </button>
                <button type="submit" class="px-4 py-2 bg-[#4D44B5] text-white rounded-lg hover:bg-[#3a32a1] transition">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

@endsection