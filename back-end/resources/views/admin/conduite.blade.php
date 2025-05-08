@extends('layouts.admin')

@section('content')
<div class="flex-1 overflow-auto p-4 md:p-6">
    <header class="bg-[#4D44B5] text-white shadow-md rounded-lg mb-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                <h1 class="text-xl md:text-2xl font-bold">Cours de Conduite</h1>
                <button id="newCourseBtn"
                    class="bg-white text-[#4D44B5] px-4 py-2 rounded-lg font-medium hover:bg-gray-100 hover:shadow-sm transition-all duration-300 flex items-center w-max">
                    <i class="fas fa-plus mr-2"></i> Nouveau Cours
                </button>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto">
     

        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="px-4 sm:px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">Liste des Cours Programmes</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 hidden sm:table-header-group">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date/Heure</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durée</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">Moniteur</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Véhicule</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Candidats</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($cours as $cour)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="sm:hidden text-xs font-medium text-gray-500 uppercase mb-1">Date/Heure</div>
                                <span class="font-medium text-gray-900">{{ $cour->date_heure->format('d/m/Y H:i') }}</span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="sm:hidden text-xs font-medium text-gray-500 uppercase mb-1">Durée</div>
                                <span>{{ $cour->duree_minutes }} min</span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap hidden sm:table-cell">
                                @if($cour->moniteur)
                                    {{ $cour->moniteur->nom }} {{ $cour->moniteur->prenom }}
                                @else
                                    <span class="text-red-500">Non assigné</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap hidden md:table-cell">
                                @if($cour->vehicule)
                                    {{ $cour->vehicule->marque }} ({{ $cour->vehicule->immatriculation }})
                                @else
                                    <span class="text-red-500">Non assigné</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="sm:hidden text-xs font-medium text-gray-500 uppercase mb-1">Candidats</div>
                                <div class="text-sm">
                                    @if($cour->candidat)
                                        <div class="flex items-center">
                                            @if($cour->presences->where('candidat_id', $cour->candidat_id)->first())
                                                @if($cour->presences->where('candidat_id', $cour->candidat_id)->first()->present)
                                                    <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                                                @else
                                                    <div class="w-2 h-2 bg-red-500 rounded-full mr-2"></div>
                                                @endif
                                            @endif
                                            <span class="font-medium">{{ $cour->candidat->nom }} {{ $cour->candidat->prenom }}</span>
                                        </div>
                                        
                                        @if($cour->candidats->count() > 1 || ($cour->candidats->count() == 1 && $cour->candidats->first()->id != $cour->candidat_id))
                                            <span class="text-gray-500 text-xs mt-1">+ {{ $cour->candidats->count() - ($cour->candidat ? 1 : 0) }} autre(s)</span>
                                        @endif
                                    @else
                                        <span class="text-red-500">Aucun candidat principal</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="sm:hidden text-xs font-medium text-gray-500 uppercase mb-1">Statut</div>
                                <span class="px-2 py-1 text-xs rounded-full 
                                    @if($cour->statut === 'planifie') bg-blue-100 text-blue-800
                                    @elseif($cour->statut === 'termine') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($cour->statut) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                <div class="sm:hidden text-xs font-medium text-gray-500 uppercase mb-1">Actions</div>
                                <div class="flex space-x-3">
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
                                        class="text-[#4D44B5] hover:text-[#3a32a1]">
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
                <div class="px-4 py-3">
                    {{ $cours->links() }}
                </div>
            </div>
        </div>
    </main>

    <div id="courseModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50 p-4">
        <div class="bg-white w-full max-w-xl p-6 rounded-lg overflow-y-auto max-h-[90vh]">
            <h2 id="modalCourseTitle" class="text-xl font-bold mb-5">Nouveau Cours de Conduite</h2>
            <form id="courseForm" method="POST">
                @csrf
                <input type="hidden" id="courseId" name="id">
                <input type="hidden" id="_method" name="_method" value="POST">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="courseDateHeure" class="block text-sm font-medium text-gray-700 mb-1">Date/Heure *</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-calendar-alt text-gray-400"></i>
                            </div>
                            <input type="datetime-local" id="courseDateHeure" name="date_heure"
                                class="w-full pl-10 pr-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-[#4D44B5] outline-none" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="courseDuree" class="block text-sm font-medium text-gray-700 mb-1">Durée (minutes) *</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-clock text-gray-400"></i>
                            </div>
                            <input type="number" id="courseDuree" name="duree_minutes" min="30" max="240"
                                class="w-full pl-10 pr-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-[#4D44B5] outline-none" required>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500">min</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="courseMoniteur" class="block text-sm font-medium text-gray-700 mb-1">Moniteur *</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user-tie text-gray-400"></i>
                            </div>
                            <select id="courseMoniteur" name="moniteur_id" 
                                class="w-full pl-10 pr-10 py-2.5 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-[#4D44B5] outline-none appearance-none" required>
                                <option value="">Sélectionner un moniteur</option>
                                @foreach($moniteurs as $moniteur)
                                    <option value="{{ $moniteur->id }}">{{ $moniteur->nom }} {{ $moniteur->prenom }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-500"></i>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="courseVehicule" class="block text-sm font-medium text-gray-700 mb-1">Véhicule *</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-car text-gray-400"></i>
                            </div>
                            <select id="courseVehicule" name="vehicule_id" 
                                class="w-full pl-10 pr-10 py-2.5 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-[#4D44B5] outline-none appearance-none" required>
                                <option value="">Sélectionner un véhicule</option>
                                @foreach($vehicules as $vehicule)
                                    <option value="{{ $vehicule->id }}">{{ $vehicule->marque }} ({{ $vehicule->immatriculation }})</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-500"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="courseCandidatPrincipal" class="block text-sm font-medium text-gray-700 mb-1">Candidat Principal *</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <select id="courseCandidatPrincipal" name="candidat_id" 
                            class="w-full pl-10 pr-10 py-2.5 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-[#4D44B5] outline-none appearance-none" required>
                            <option value="">Sélectionner un candidat</option>
                            @foreach($candidats as $candidat)
                                <option value="{{ $candidat->id }}">{{ $candidat->nom }} {{ $candidat->prenom }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <i class="fas fa-chevron-down text-gray-500"></i>
                        </div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="courseCandidatsSupplementaires" class="block text-sm font-medium text-gray-700 mb-1">Candidats Supplémentaires</label>
                    <div class="relative">
                        <div class="absolute top-3 left-0 pl-3 pointer-events-none">
                            <i class="fas fa-users text-gray-400"></i>
                        </div>
                        <select id="courseCandidatsSupplementaires" name="candidat_ids[]" multiple
                            class="w-full pl-10 py-2.5 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-[#4D44B5] outline-none">
                            @foreach($candidats as $candidat)
                                <option value="{{ $candidat->id }}">{{ $candidat->nom }} {{ $candidat->prenom }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="courseStatut" class="block text-sm font-medium text-gray-700 mb-1">Statut *</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-info-circle text-gray-400"></i>
                        </div>
                        <select id="courseStatut" name="statut" 
                            class="w-full pl-10 pr-10 py-2.5 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-[#4D44B5] outline-none appearance-none" required>
                            <option value="planifie">Planifié</option>
                            <option value="termine">Terminé</option>
                            <option value="annule">Annulé</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <i class="fas fa-chevron-down text-gray-500"></i>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" id="cancelCourseBtn"
                        class="px-5 py-2.5 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                        Annuler
                    </button>
                    <button type="submit" id="submitCourseBtn"
                        class="px-5 py-2.5 bg-[#4D44B5] text-white rounded-lg hover:bg-[#3a32a1] transition">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="presenceModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50 p-4">
        <div class="bg-white w-full max-w-xl p-6 rounded-lg max-h-[90vh] overflow-y-auto">
            <h2 class="text-xl font-bold mb-5">Présences des Candidats</h2>
            <div id="presenceModalContent">
                <div class="text-center py-4">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-[#4D44B5] mx-auto"></div>
                    <p class="mt-2 text-gray-600">Chargement des données...</p>
                </div>
            </div>
            <div class="mt-6 flex justify-end">
                <button type="button" onclick="closePresenceModal()"
                    class="px-5 py-2.5 bg-[#4D44B5] text-white rounded-lg hover:bg-[#3a32a1] transition">
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
                                <p class="text-sm text-gray-600">Moniteur: ${course.moniteur?.nom || 'Non assigné'} ${course.moniteur?.prenom || ''}</p>
                                <p class="text-sm text-gray-600">Véhicule: ${course.vehicule?.marque || 'Non assigné'} ${course.vehicule?.immatriculation ? '('+course.vehicule.immatriculation+')' : ''}</p>
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
                    } else {
                        html += `
                            <div class="space-y-2">
                                <h4 class="font-medium">Candidat Principal:</h4>
                                <div class="p-3 bg-gray-50 rounded text-red-500">
                                    Aucun candidat principal assigné
                                </div>
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
                } else {
                    $('#presenceModalContent').html(`
                        <div class="text-center py-4 text-red-500">
                            <i class="fas fa-exclamation-circle text-2xl mb-2"></i>
                            <p>${response.message || 'Erreur inconnue'}</p>
                        </div>
                    `);
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
.select2-container--default .select2-selection--multiple {
    border: 1px solid #d1d5db;
    border-radius: 0.5rem;
    padding: 0.5rem 1rem 0.5rem 2.5rem;
    min-height: 42px;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #4D44B5;
    border: none;
    border-radius: 0.25rem;
    color: white;
    padding: 0.25rem 0.5rem;
    margin: 0.125rem;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    color: white;
    margin-left: 0.5rem;
}
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

@media (max-width: 640px) {
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