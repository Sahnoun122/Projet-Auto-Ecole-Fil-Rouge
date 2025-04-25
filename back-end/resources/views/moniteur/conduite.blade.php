@extends('layouts.moniteur')

@section('content')
<div class="w-full">
    <header class="bg-[#4D44B5] text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <h1 class="text-xl sm:text-2xl font-bold">Mes Cours de Conduite</h1>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    
        <div class="bg-white rounded-xl shadow overflow-hidden mb-8">
            <div class="px-4 sm:px-6 py-4 border-b border-gray-200 bg-[#4D44B5]/10">
                <h2 class="text-lg sm:text-xl font-semibold text-gray-800">Cours Planifiés</h2>
                <p class="text-sm text-gray-600 mt-1">Gérez les présences et notes de vos élèves</p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-xs sm:text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-3 text-left font-medium text-gray-500 uppercase tracking-wider text-xs">Date/Heure</th>
                            <th class="px-3 py-3 text-left font-medium text-gray-500 uppercase tracking-wider text-xs">Durée</th>
                            <th class="px-3 py-3 text-left font-medium text-gray-500 uppercase tracking-wider text-xs hidden sm:table-cell">Véhicule</th>
                            <th class="px-3 py-3 text-left font-medium text-gray-500 uppercase tracking-wider text-xs">Candidats</th>
                            <th class="px-3 py-3 text-left font-medium text-gray-500 uppercase tracking-wider text-xs">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($cours as $cour)
                        <tr data-course-id="{{ $cour->id }}" class="hover:bg-gray-50 transition-colors">
                            <td class="px-3 py-3 whitespace-nowrap" data-label="Date/Heure">
                                <div class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($cour->date_heure)->format('d/m/Y') }}</div>
                                <div class="text-gray-500">{{ \Carbon\Carbon::parse($cour->date_heure)->format('H:i') }}</div>
                            </td>
                            <td class="px-3 py-3 whitespace-nowrap" data-label="Durée">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $cour->duree_minutes }} min
                                </span>
                            </td>
                            <td class="px-3 py-3 whitespace-nowrap hidden sm:table-cell" data-label="Véhicule">
                                @if($cour->vehicule)
                                    <div class="flex items-center">
                                        <span class="text-gray-900">{{ $cour->vehicule->marque }}</span>
                                        <span class="ml-1 text-gray-500 text-xs">({{ $cour->vehicule->immatriculation }})</span>
                                    </div>
                                @else
                                    <span class="text-red-500">Non assigné</span>
                                @endif
                            </td>
                            <td class="px-3 py-3" data-label="Candidats">
                                <div class="flex flex-wrap gap-1">
                                    @if($cour->candidat)
                                        <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-xs flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            {{ $cour->candidat->nom }} {{ $cour->candidat->prenom }}
                                            @php
                                                $present = null;
                                                $presenceRecord = $cour->presences->where('candidat_id', $cour->candidat_id)->first();
                                                if ($presenceRecord) {
                                                    $present = $presenceRecord->present;
                                                }
                                            @endphp
                                            @if($present !== null)
                                                @if($present)
                                                    <span class="ml-1 h-2 w-2 bg-green-500 rounded-full" title="Présent"></span>
                                                @else
                                                    <span class="ml-1 h-2 w-2 bg-red-500 rounded-full" title="Absent"></span>
                                                @endif
                                            @endif
                                        </span>
                                    @endif
                            
                                    @foreach($cour->presences as $presence)
                                        @if(!$cour->candidat || $presence->candidat_id != $cour->candidat_id)
                                            @php
                                                $candidat = \App\Models\User::find($presence->candidat_id);
                                            @endphp
                                            @if($candidat)
                                            <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-xs flex items-center">
                                                {{ $candidat->nom }} {{ $candidat->prenom }}
                                                @if($presence->present)
                                                    <span class="ml-1 h-2 w-2 bg-green-500 rounded-full" title="Présent"></span>
                                                @else
                                                    <span class="ml-1 h-2 w-2 bg-red-500 rounded-full" title="Absent"></span>
                                                @endif
                                            </span>
                                            @endif
                                        @endif
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-3 py-3 whitespace-nowrap text-sm font-medium" data-label="Actions">
                                <button type="button" class="show-presence-btn text-white bg-[#4D44B5] hover:bg-[#3a32a1] px-3 py-1.5 rounded-lg text-xs sm:text-sm transition-colors flex items-center"
                                    data-course-id="{{ $cour->id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Présence & Notes
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="font-medium">Aucun cours planifié</p>
                                <p class="text-sm mt-1">Les cours que vous planifiez apparaîtront ici</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-4 py-4 border-t border-gray-200">
                    {{ $cours->links() }}
                </div>
            </div>
        </div>
    </main>
</div>

@foreach($cours as $cour)
<div id="presenceModal-{{ $cour->id }}" class="fixed inset-0 bg-gray-900 bg-opacity-60 flex justify-center items-center z-50 p-4 modal-presence" style="display: none;">
    <div class="bg-white w-full max-w-lg rounded-lg shadow-xl overflow-hidden">
        <div class="px-4 sm:px-6 py-4 border-b border-gray-200 bg-[#4D44B5] text-white">
            <h2 class="text-lg font-bold">Gestion des Présences & Notes</h2>
            <p class="course-date text-sm opacity-90 mt-1">Cours du {{ \Carbon\Carbon::parse($cour->date_heure)->format('d/m/Y à H:i') }}</p>
        </div>

        <form method="POST" action="{{ route('moniteur.conduite.presences', $cour->id) }}" class="presence-form">
            @csrf
            <div class="p-4 sm:p-6 space-y-4 max-h-[60vh] overflow-y-auto">
                @if($cour->candidat)
                    <div class="main-candidate border rounded-lg p-4 bg-gray-50 shadow-sm">
                        <h3 class="font-medium text-lg mb-3 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#4D44B5]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Candidat Principal
                        </h3>
                        <div class="candidate-presence space-y-4">
                            <div class="flex items-center justify-between p-2 bg-white rounded-lg border border-gray-200">
                                <span class="candidate-name font-medium">{{ $cour->candidat->nom }} {{ $cour->candidat->prenom }}</span>
                                <label class="inline-flex items-center">
                                    @php
                                        $principalPresence = $cour->presences->where('candidat_id', $cour->candidat_id)->first();
                                        $principalPresent = $principalPresence ? $principalPresence->present : false;
                                        $principalNotes = $principalPresence ? $principalPresence->notes : '';
                                    @endphp
                                    <input type="checkbox" name="present[{{ $cour->candidat_id }}]" value="1" 
                                        class="rounded border-gray-300 text-[#4D44B5] focus:ring-[#4D44B5] h-5 w-5"
                                        {{ $principalPresent ? 'checked' : '' }}>
                                    <span class="ml-2">Présent(e)</span>
                                </label>
                            </div>
                            <div class="bg-white rounded-lg p-3 border border-gray-200">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <span class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-[#4D44B5]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Notes d'évaluation
                                    </span>
                                </label>
                                <textarea name="notes[{{ $cour->candidat_id }}]" rows="3" 
                                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] resize-none"
                                    placeholder="Ajoutez vos observations sur la performance du candidat...">{{ $principalNotes }}</textarea>
                            </div>
                        </div>
                    </div>
                @endif

              
            </div>

            <div class="px-4 sm:px-6 py-4 border-t border-gray-200 flex justify-end space-x-3 bg-gray-50">
                <button type="button" class="cancel-presence-btn px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                    Annuler
                </button>
                <button type="submit" class="px-4 py-2 bg-[#4D44B5] text-white rounded-lg hover:bg-[#3a32a1] transition flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
@endforeach


@endsection
