@extends('layouts.admin')

@section('content')
<div class="overflow-x-auto w-full">
    <header class="bg-[#4D44B5] text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col sm:flex-row justify-between items-center space-y-2 sm:space-y-0">
            <h1 class="text-xl sm:text-2xl font-bold">Cours de Conduite</h1>
            <button id="newCourseBtn"
                class="bg-white text-[#4D44B5] px-3 py-1 sm:px-4 sm:py-2 rounded-lg font-medium hover:bg-gray-100 transition text-sm sm:text-base">
                <i class="fas fa-plus mr-1 sm:mr-2"></i> Nouveau Cours
            </button>
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
                <h2 class="text-lg sm:text-xl font-semibold text-gray-800">Liste des Cours Programmes</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-xs sm:text-sm md:text-base">
                    <thead class="bg-gray-50 hidden sm:table-header-group">
                        <tr>
                            <th class="px-3 py-2 sm:px-4 sm:py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Date/Heure</th>
                            <th class="px-3 py-2 sm:px-4 sm:py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Durée</th>
                            <th class="px-3 py-2 sm:px-4 sm:py-3 text-left font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">Moniteur</th>
                            <th class="px-3 py-2 sm:px-4 sm:py-3 text-left font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Véhicule</th>
                            <th class="px-3 py-2 sm:px-4 sm:py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Candidats</th>
                            <th class="px-3 py-2 sm:px-4 sm:py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-3 py-2 sm:px-4 sm:py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($cours as $cour)
                        <tr class="block sm:table-row mb-4 sm:mb-0">
                            <td class="px-3 py-2 sm:px-4 sm:py-4 whitespace-nowrap block sm:table-cell">
                                <span class="sm:hidden font-medium">Date/Heure:</span>
                                {{ $cour->date_heure }}
                            </td>
                            <td class="px-3 py-2 sm:px-4 sm:py-4 whitespace-nowrap block sm:table-cell">
                                <span class="sm:hidden font-medium">Durée:</span>
                                {{ $cour->duree_minutes }} min
                            </td>
                            <td class="px-3 py-2 sm:px-4 sm:py-4 whitespace-nowrap hidden sm:table-cell">
                                @if($cour->moniteur)
                                    {{ $cour->moniteur->nom }} {{ $cour->moniteur->prenom }}
                                @else
                                    <span class="text-red-500">Non assigné</span>
                                @endif
                            </td>
                            <td class="px-3 py-2 sm:px-4 sm:py-4 whitespace-nowrap hidden md:table-cell">
                                @if($cour->vehicule)
                                    {{ $cour->vehicule->marque }} ({{ $cour->vehicule->immatriculation }})
                                @else
                                    <span class="text-red-500">Non assigné</span>
                                @endif
                            </td>
                            <td class="px-3 py-2 sm:px-4 sm:py-4 block sm:table-cell">
                                <div class="flex flex-wrap gap-1 max-w-[150px] sm:max-w-none overflow-x-auto">
                                    @if($cour->candidat)
                                        <span class="bg-blue-100 text-blue-800 px-1 py-0.5 sm:px-2 sm:py-1 rounded text-xs">
                                            {{ $cour->candidat->nom }} {{ $cour->candidat->prenom }} (P)
                                        </span>
                                    @else
                                        <span class="text-red-500 text-xs">Aucun candidat principal</span>
                                    @endif
                            
                                    @foreach($cour->candidats as $candidat)
                                        @if(!$cour->candidat || $candidat->id != $cour->candidat_id)
                                            <span class="bg-gray-100 text-gray-800 px-1 py-0.5 sm:px-2 sm:py-1 rounded text-xs">
                                                {{ $candidat->nom }} {{ $candidat->prenom }}
                                            </span>
                                        @endif
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-3 py-2 sm:px-4 sm:py-4 whitespace-nowrap block sm:table-cell">
                                <span class="px-1 py-0.5 sm:px-2 sm:py-1 text-xs rounded-full 
                                    @if($cour->statut === 'planifie') bg-blue-100 text-blue-800
                                    @elseif($cour->statut === 'termine') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($cour->statut) }}
                                </span>
                            </td>
                            <td class="px-3 py-2 sm:px-4 sm:py-4 whitespace-nowrap text-xs sm:text-sm font-medium block sm:table-cell">
                                <div class="flex space-x-1 sm:space-x-2 justify-end sm:justify-start">
                                    <button onclick="openEditModal(
                                        '{{ $cour->id }}',
                                        '{{ $cour->date_heure }}',
                                        '{{ $cour->duree_minutes }}',
                                        '{{ $cour->moniteur_id }}',
                                        '{{ $cour->vehicule_id }}',
                                        '{{ $cour->candidat_id }}',
                                        `{{ json_encode($cour->candidats->pluck('id')->toArray()) }}`,
                                        '{{ $cour->statut }}'
                                    )" class="text-[#4D44B5] hover:text-[#3a32a1]">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('admin.conduite.destroy', $cour->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?')"
                                            class="text-red-500 hover:text-red-700">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    <button onclick="openPresenceModal('{{ $cour->id }}')" 
                                        class="text-purple-600 hover:text-purple-800">
                                        <i class="fas fa-user-check"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
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

    <!-- Course Modal -->
    <div id="courseModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50 p-4">
        <div class="bg-white w-full max-w-md md:max-w-2xl p-4 md:p-6 rounded-lg overflow-y-auto max-h-screen">
            <h2 id="modalCourseTitle" class="text-lg font-bold mb-4">Nouveau Cours de Conduite</h2>
            <form id="courseForm" method="POST">
                @csrf
                <input type="hidden" id="courseId" name="id">
                <input type="hidden" id="_method" name="_method" value="POST">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-3">
                        <label for="courseDateHeure" class="block text-sm font-medium text-gray-700 mb-1">Date/Heure *</label>
                        <input type="datetime-local" id="courseDateHeure" name="date_heure"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                    </div>

                    <div class="mb-3">
                        <label for="courseDuree" class="block text-sm font-medium text-gray-700 mb-1">Durée (minutes) *</label>
                        <input type="number" id="courseDuree" name="duree_minutes" min="30" max="240"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-3">
                        <label for="courseMoniteur" class="block text-sm font-medium text-gray-700 mb-1">Moniteur *</label>
                        <select id="courseMoniteur" name="moniteur_id" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                            <option value="">Sélectionner un moniteur</option>
                            @foreach($moniteurs as $moniteur)
                                <option value="{{ $moniteur->id }}">{{ $moniteur->nom }} {{ $moniteur->prenom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="courseVehicule" class="block text-sm font-medium text-gray-700 mb-1">Véhicule *</label>
                        <select id="courseVehicule" name="vehicule_id" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                            <option value="">Sélectionner un véhicule</option>
                            @foreach($vehicules as $vehicule)
                                <option value="{{ $vehicule->id }}">{{ $vehicule->marque }} ({{ $vehicule->immatriculation }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="courseCandidatPrincipal" class="block text-sm font-medium text-gray-700 mb-1">Candidat Principal *</label>
                    <select id="courseCandidatPrincipal" name="candidat_id" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                        <option value="">Sélectionner un candidat</option>
                        @foreach($candidats as $candidat)
                            <option value="{{ $candidat->id }}">{{ $candidat->nom }} {{ $candidat->prenom }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-3">
                    <label for="courseCandidatsSupplementaires" class="block text-sm font-medium text-gray-700 mb-1">Candidats Supplémentaires</label>
                    <select id="courseCandidatsSupplementaires" name="candidat_ids[]" multiple
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]">
                        @foreach($candidats as $candidat)
                            <option value="{{ $candidat->id }}">{{ $candidat->nom }} {{ $candidat->prenom }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="courseStatut" class="block text-sm font-medium text-gray-700 mb-1">Statut *</label>
                    <select id="courseStatut" name="statut" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                        <option value="planifie">Planifié</option>
                        <option value="termine">Terminé</option>
                        <option value="annule">Annulé</option>
                    </select>
                </div>
                
                <div class="flex justify-end space-x-2">
                    <button type="button" id="cancelCourseBtn"
                        class="px-3 py-1 md:px-4 md:py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition text-sm md:text-base">
                        Annuler
                    </button>
                    <button type="submit" id="submitCourseBtn"
                        class="px-3 py-1 md:px-4 md:py-2 bg-[#4D44B5] text-white rounded-lg hover:bg-[#3a32a1] transition text-sm md:text-base">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="presenceModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50 p-4">
        <div class="bg-white w-full max-w-md p-4 md:p-6 rounded-lg">
            <h2 class="text-lg font-bold mb-4">Présences des Candidats</h2>
            @if(isset($selectedCourse))
            <div class="space-y-4">
                <div class="border-b pb-2 mb-4">
                    <h3 class="text-md font-medium">Cours du {{ $selectedCourse->date_heure->format('d/m/Y H:i') }}</h3>
                    <p class="text-sm text-gray-600">Moniteur: {{ $selectedCourse->moniteur->nom }} {{ $selectedCourse->moniteur->prenom }}</p>
                </div>

                <div class="space-y-2">
                    <h4 class="font-medium">Candidat Principal:</h4>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                        <span>{{ $selectedCourse->candidat->nom }} {{ $selectedCourse->candidat->prenom }}</span>
                        <span class="px-2 py-1 text-xs rounded-full 
                            {{ $selectedCourse->candidats->find($selectedCourse->candidat->id)->pivot->present ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $selectedCourse->candidats->find($selectedCourse->candidat->id)->pivot->present ? 'Présent' : 'Absent' }}
                        </span>
                    </div>
                    @if($selectedCourse->candidats->find($selectedCourse->candidat->id)->pivot->notes)
                    <div class="mt-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Notes du moniteur:</label>
                        <p class="text-gray-600 mt-1">{{ $selectedCourse->candidats->find($selectedCourse->candidat->id)->pivot->notes }}</p>
                    </div>
                    @endif
                </div>

                @if($selectedCourse->candidats->count() > 1)
                <div class="space-y-2">
                    <h4 class="font-medium">Autres Candidats:</h4>
                    @foreach($selectedCourse->candidats as $candidat)
                        @if($candidat->id != $selectedCourse->candidat_id)
                        <div class="space-y-2 p-3 bg-gray-50 rounded">
                            <div class="flex items-center justify-between">
                                <span>{{ $candidat->nom }} {{ $candidat->prenom }}</span>
                                <span class="px-2 py-1 text-xs rounded-full 
                                    {{ $candidat->pivot->present ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $candidat->pivot->present ? 'Présent' : 'Absent' }}
                                </span>
                            </div>
                            @if($candidat->pivot->notes)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Notes du moniteur:</label>
                                <p class="text-gray-600">{{ $candidat->pivot->notes }}</p>
                            </div>
                            @endif
                        </div>
                        @endif
                    @endforeach
                </div>
                @endif
            </div>
            @endif
            <div class="mt-4 flex justify-end">
                <button type="button" id="closePresenceBtn"
                    class="px-3 py-1 md:px-4 md:py-2 bg-[#4D44B5] text-white rounded-lg hover:bg-[#3a32a1] transition text-sm md:text-base">
                    Fermer
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<script>
$(document).ready(function() {
    $('#courseCandidatsSupplementaires').select2({
        placeholder: "Sélectionner des candidats",
        width: '100%',
        dropdownParent: $('#courseModal')
    });

    $('#newCourseBtn').click(function() {
        $('#modalCourseTitle').text('Nouveau Cours de Conduite');
        $('#courseForm').attr('action', "{{ route('admin.conduite.store') }}");
        $('#_method').val('POST');
        $('#courseId').val('');
        $('#courseForm')[0].reset();
        $('#courseDateHeure').val(new Date().toISOString().slice(0, 16));
        $('#courseModal').removeClass('hidden');
        $('body').addClass('overflow-hidden');
    });

    window.openEditModal = function(id, dateHeure, duree, moniteurId, vehiculeId, candidatId, candidatIds, statut) {
        $('#modalCourseTitle').text('Modifier Cours de Conduite');
        $('#courseForm').attr('action', "/admin/conduite/" + id);
        $('#_method').val('PUT');
        $('#courseId').val(id);
        
        const formattedDate = dateHeure.replace(' ', 'T');
        $('#courseDateHeure').val(formattedDate);
        
        $('#courseDuree').val(duree);
        $('#courseMoniteur').val(moniteurId);
        $('#courseVehicule').val(vehiculeId);
        $('#courseCandidatPrincipal').val(candidatId);
        $('#courseStatut').val(statut);
        
        try {
            const ids = Array.isArray(candidatIds) ? candidatIds : JSON.parse(candidatIds.replace(/&quot;/g, '"'));
            $('#courseCandidatsSupplementaires').val(ids).trigger('change');
        } catch (e) {
            console.error('Error parsing candidat_ids:', e);
        }
        
        $('#courseModal').removeClass('hidden');
        $('body').addClass('overflow-hidden');
    };

    window.openPresenceModal = function(courseId) {
        window.location.href = "{{ route('admin.conduite.presence', '') }}/" + courseId;
    };

    $('#cancelCourseBtn, #closePresenceBtn').click(function() {
        $('#courseModal, #presenceModal').addClass('hidden');
        $('body').removeClass('overflow-hidden');
    });

    // Close modal when clicking outside
    $(document).mouseup(function(e) {
        const courseModal = $('#courseModal');
        const presenceModal = $('#presenceModal');
        
        if (!courseModal.is(e.target) && courseModal.has(e.target).length === 0) {
            courseModal.addClass('hidden');
            $('body').removeClass('overflow-hidden');
        }
        
        if (!presenceModal.is(e.target) && presenceModal.has(e.target).length === 0) {
            presenceModal.addClass('hidden');
            $('body').removeClass('overflow-hidden');
        }
    });

    @if(isset($selectedCourse))
        $('#presenceModal').removeClass('hidden');
        $('body').addClass('overflow-hidden');
    @endif
});
</script>

<style>
.select2-container--default .select2-selection--multiple {
    border: 1px solid #d1d5db;
    border-radius: 0.5rem;
    padding: 0.25rem;
    min-height: 42px;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #4D44B5;
    border: none;
    border-radius: 0.25rem;
    color: white;
    padding: 0 0.5rem;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    color: white;
    margin-right: 2px;
}

@media (max-width: 640px) {
    /* Stack table cells vertically on small screens */
    table {
        border: 0;
    }
    
    table thead {
        display: none;
    }
    
    table tr {
        display: block;
        margin-bottom: 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
    }
    
    table td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem;
        border-bottom: 1px solid #e2e8f0;
        text-align: right;
    }
    
    table td:last-child {
        border-bottom: 0;
    }
    
    table td::before {
        content: attr(data-label);
        font-weight: bold;
        margin-right: 1rem;
    }
    
    /* Make select2 responsive */
    .select2-container {
        width: 100% !important;
    }
    
    #courseModal > div, #presenceModal > div {
        width: 95%;
        margin: 0 auto;
        max-height: 90vh;
    }
}

.select2-dropdown {
    z-index: 10060 !important; 
}
</style>
@endsection