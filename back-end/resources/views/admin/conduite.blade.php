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
                                {{ $cour->date_heure->format('d/m/Y H:i') }}
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
                                        '{{ $cour->date_heure->format('Y-m-d\TH:i') }}',
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
                                    <button onclick="loadPresences({{ $cour->id }})" 
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
        <!-- ... contenu existant de la modal de cours ... -->
    </div>

    <!-- Presence Modal -->
    <div id="presenceModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50 p-4">
        <div class="bg-white w-full max-w-md p-4 md:p-6 rounded-lg max-h-[90vh] overflow-y-auto">
            <h2 class="text-lg font-bold mb-4">Présences des Candidats</h2>
            <div id="presenceModalContent">
                <!-- Le contenu sera chargé dynamiquement via AJAX -->
                <div class="text-center py-4">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-[#4D44B5] mx-auto"></div>
                    <p class="mt-2 text-gray-600">Chargement des données...</p>
                </div>
            </div>
            <div class="mt-4 flex justify-end">
                <button type="button" onclick="closePresenceModal()"
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
        $('#courseDateHeure').val(dateHeure);
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

    window.loadPresences = function(courseId) {
        $('#presenceModal').removeClass('hidden');
        $('body').addClass('overflow-hidden');
        
        $.ajax({
            url: '/admin/conduite/' + courseId + '/presences',
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    const course = response.data.course;
                    const presences = response.data.presences;
                    
                    let html = `
                        <div class="space-y-4">
                            <div class="border-b pb-2 mb-4">
                                <h3 class="text-md font-medium">Cours du ${new Date(course.date_heure).toLocaleDateString('fr-FR', {day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit'})}</h3>
                                <p class="text-sm text-gray-600">Moniteur: ${course.moniteur.nom} ${course.moniteur.prenom}</p>
                                <p class="text-sm text-gray-600">Véhicule: ${course.vehicule.marque} (${course.vehicule.immatriculation})</p>
                            </div>
                    `;
                    
                    const principal = presences.find(p => p.is_principal);
                    if (principal) {
                        html += `
                            <div class="space-y-2">
                                <h4 class="font-medium">Candidat Principal:</h4>
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                                    <span>${principal.nom} ${principal.prenom}</span>
                                    <span class="px-2 py-1 text-xs rounded-full ${principal.present ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                                        ${principal.present ? 'Présent' : 'Absent'}
                                    </span>
                                </div>
                                ${principal.notes ? `
                                <div class="mt-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Notes du moniteur:</label>
                                    <p class="text-gray-600 mt-1">${principal.notes}</p>
                                </div>
                                ` : ''}
                            </div>
                        `;
                    }
                    
                    const autresCandidats = presences.filter(p => !p.is_principal);
                    if (autresCandidats.length > 0) {
                        html += `
                            <div class="space-y-2">
                                <h4 class="font-medium">Autres Candidats:</h4>
                                ${autresCandidats.map(candidat => `
                                    <div class="space-y-2 p-3 bg-gray-50 rounded">
                                        <div class="flex items-center justify-between">
                                            <span>${candidat.nom} ${candidat.prenom}</span>
                                            <span class="px-2 py-1 text-xs rounded-full ${candidat.present ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                                                ${candidat.present ? 'Présent' : 'Absent'}
                                            </span>
                                        </div>
                                        ${candidat.notes ? `
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Notes du moniteur:</label>
                                            <p class="text-gray-600">${candidat.notes}</p>
                                        </div>
                                        ` : ''}
                                    </div>
                                `).join('')}
                            </div>
                        `;
                    }
                    
                    html += `</div>`;
                    $('#presenceModalContent').html(html);
                }
            },
            error: function(xhr) {
                $('#presenceModalContent').html(`
                    <div class="text-center py-4 text-red-500">
                        <i class="fas fa-exclamation-circle text-2xl mb-2"></i>
                        <p>Une erreur est survenue lors du chargement des données.</p>
                    </div>
                `);
            }
        });
    };

    window.closePresenceModal = function() {
        $('#presenceModal').addClass('hidden');
        $('body').removeClass('overflow-hidden');
    };

    $('#cancelCourseBtn').click(function() {
        $('#courseModal').addClass('hidden');
        $('body').removeClass('overflow-hidden');
    });

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
});
</script>

<style>
/* Styles existants... */
.presence-badge {
    display: inline-block;
    padding: 0.25rem 0.5rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 500;
}

.presence-badge.present {
    background-color: #D1FAE5;
    color: #065F46;
}

.presence-badge.absent {
    background-color: #FEE2E2;
    color: #B91C1C;
}

/* ... autres styles existants ... */
</style>
@endsection