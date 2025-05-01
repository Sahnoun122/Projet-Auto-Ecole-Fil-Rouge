@extends('layouts.admin')

@section('content')
<div class="flex-1 overflow-auto p-4 md:p-6">
    <header class="bg-[#4D44B5] text-white shadow-md rounded-lg mb-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                <h1 class="text-xl md:text-2xl font-bold">Gestion des Examens</h1>
                <button id="newExamBtn" 
                    class="bg-white text-[#4D44B5] px-4 py-2 rounded-lg font-medium hover:bg-gray-100 hover:shadow-sm transition-all duration-300 flex items-center w-max">
                    <i class="fas fa-plus mr-2"></i> Nouvel Examen
                </button>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="px-4 sm:px-6 py-4 border-b border-gray-200 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <h2 class="text-lg font-semibold text-gray-800">Liste des Examens</h2>
                <div class="relative w-full md:w-auto">
                    <input type="text" id="examSearch" placeholder="Rechercher..." 
                        class="pl-10 pr-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-[#4D44B5] outline-none w-full">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 hidden sm:table-header-group">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lieu</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Candidat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($exams as $exam)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="sm:hidden text-xs font-medium text-gray-500 uppercase mb-1">Type</div>
                                <span class="px-2 py-1 text-xs rounded-full 
                                    {{ $exam->type === 'theorique' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                    {{ ucfirst($exam->type) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="sm:hidden text-xs font-medium text-gray-500 uppercase mb-1">Date</div>
                                <span>{{ $exam->date_exam->format('d/m/Y H:i') }}</span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="sm:hidden text-xs font-medium text-gray-500 uppercase mb-1">Lieu</div>
                                <span>{{ $exam->lieu }}</span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="sm:hidden text-xs font-medium text-gray-500 uppercase mb-1">Candidat</div>
                                @if($exam->candidat)
                                    <div class="font-medium text-[#4D44B5]">{{ $exam->candidat->prenom }} {{ $exam->candidat->nom }}</div>
                                @else
                                    <span class="text-gray-500">Non assigné</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="sm:hidden text-xs font-medium text-gray-500 uppercase mb-1">Statut</div>
                                <span class="px-2 py-1 text-xs rounded-full 
                                    {{ $exam->statut === 'planifie' ? 'bg-yellow-100 text-yellow-800' : 
                                       ($exam->statut === 'en_cours' ? 'bg-blue-100 text-blue-800' : 
                                       ($exam->statut === 'termine' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800')) }}">
                                    {{ ucfirst(str_replace('_', ' ', $exam->statut)) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                <div class="sm:hidden text-xs font-medium text-gray-500 uppercase mb-1">Actions</div>
                                <div class="flex items-center space-x-3">
                                    <button onclick="openEditModal(
                                        '{{ $exam->id }}',
                                        '{{ $exam->type }}',
                                        '{{ $exam->date_exam->format('Y-m-d\TH:i') }}',
                                        '{{ $exam->lieu }}',
                                        '{{ $exam->places_max }}',
                                        '{{ $exam->candidat_id }}',
                                        '{{ $exam->instructions }}',
                                        '{{ $exam->statut }}'
                                    )" class="text-[#4D44B5] hover:text-[#3a32a1]">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    
                                    <button onclick="openDetailsModal(
                                        '{{ $exam->id }}',
                                        '{{ $exam->type }}',
                                        '{{ $exam->date_exam->format('d/m/Y H:i') }}',
                                        '{{ $exam->lieu }}',
                                        '{{ $exam->places_max }}',
                                        '{{ $exam->statut }}',
                                        '{{ $exam->candidat ? $exam->candidat->prenom . ' ' . $exam->candidat->nom : 'Non assigné' }}',
                                        '{{ $exam->instructions }}',
                                        '{{ $exam->result ? $exam->result->score : '' }}',
                                        '{{ $exam->result ? $exam->result->resultat : '' }}',
                                        '{{ $exam->result ? $exam->result->feedbacks : '' }}',
                                        '{{ $exam->result ? $exam->result->present : '' }}'
                                    )" class="text-[#4D44B5] hover:text-[#3a32a1]">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    
                                    <form action="{{ route('admin.exams.destroy', $exam->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet examen ?')"
                                            class="text-red-500 hover:text-red-700">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                Aucun examen programmé
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-4 py-3 border-t border-gray-200">
                    {{ $exams->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </main>

    <div id="examModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50 p-4">
        <div class="bg-white w-full max-w-xl rounded-lg shadow-xl overflow-hidden">
            <div class="bg-[#4D44B5] text-white px-6 py-4 rounded-t-lg flex justify-between items-center">
                <h2 id="modalExamTitle" class="text-xl font-bold">Nouvel Examen</h2>
                <button id="cancelExamBtn" class="text-white hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form id="examForm" method="POST" class="p-6">
                @csrf
                <input type="hidden" id="examId" name="id">
                <input type="hidden" id="_method" name="_method" value="POST">
                
                <div class="space-y-4">
                    <div>
                        <label for="examType" class="block text-sm font-medium text-gray-700 mb-1">Type *</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-clipboard-list text-gray-400"></i>
                            </div>
                            <select id="examType" name="type" 
                                class="w-full pl-10 pr-10 py-2.5 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-[#4D44B5] outline-none appearance-none" required>
                                <option value="">Sélectionnez un type</option>
                                <option value="theorique">Théorique</option>
                                <option value="pratique">Pratique</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-500"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <label for="examDate" class="block text-sm font-medium text-gray-700 mb-1">Date et heure *</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-calendar-alt text-gray-400"></i>
                            </div>
                            <input type="datetime-local" id="examDate" name="date_exam" 
                                class="w-full pl-10 pr-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-[#4D44B5] outline-none" required
                                min="{{ now()->format('Y-m-d\TH:i') }}">
                        </div>
                    </div>
                    
                    <div>
                        <label for="examLieu" class="block text-sm font-medium text-gray-700 mb-1">Lieu *</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-map-marker-alt text-gray-400"></i>
                            </div>
                            <input type="text" id="examLieu" name="lieu" maxlength="100"
                                class="w-full pl-10 pr-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-[#4D44B5] outline-none" required>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="examPlaces" class="block text-sm font-medium text-gray-700 mb-1">Places max *</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-users text-gray-400"></i>
                                </div>
                                <input type="number" id="examPlaces" name="places_max" min="1" max="50"
                                    class="w-full pl-10 pr-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-[#4D44B5] outline-none" required>
                            </div>
                        </div>
                        
                        <div>
                            <label for="examStatut" class="block text-sm font-medium text-gray-700 mb-1">Statut *</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-info-circle text-gray-400"></i>
                                </div>
                                <select id="examStatut" name="statut" 
                                    class="w-full pl-10 pr-10 py-2.5 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-[#4D44B5] outline-none appearance-none" required>
                                    <option value="planifie">Planifié</option>
                                    <option value="en_cours">En cours</option>
                                    <option value="termine">Terminé</option>
                                    <option value="annule">Annulé</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="fas fa-chevron-down text-gray-500"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <label for="examCandidat" class="block text-sm font-medium text-gray-700 mb-1">Candidat</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                            <select id="examCandidat" name="candidat_id" 
                                class="w-full pl-10 pr-10 py-2.5 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-[#4D44B5] outline-none appearance-none">
                                <option value="">Non assigné</option>
                                @foreach($candidats as $candidat)
                                    <option value="{{ $candidat->id }}">
                                        {{ $candidat->prenom }} {{ $candidat->nom }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-500"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <label for="examInstructions" class="block text-sm font-medium text-gray-700 mb-1">Instructions</label>
                        <div class="relative">
                            <div class="absolute top-3 left-0 pl-3 flex items-start pointer-events-none">
                                <i class="fas fa-file-alt text-gray-400"></i>
                            </div>
                            <textarea id="examInstructions" name="instructions" rows="3"
                                class="w-full pl-10 pr-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-[#4D44B5] outline-none"
                                maxlength="500"></textarea>
                        </div>
                        <small class="text-gray-500 text-xs mt-1 block text-right"><span id="charCount">0</span>/500 caractères</small>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" id="cancelExamBtnBottom"
                        class="px-5 py-2.5 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                        Annuler
                    </button>
                    <button type="submit" id="submitExamBtn"
                        class="px-5 py-2.5 bg-[#4D44B5] text-white rounded-lg hover:bg-[#3a32a1] transition flex items-center">
                        <i class="fas fa-save mr-2"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="detailsModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50 p-4">
        <div class="bg-white w-full max-w-2xl rounded-xl shadow-xl overflow-hidden">
            <div class="bg-[#4D44B5] text-white px-6 py-4 flex justify-between items-center">
                <h2 id="modalDetailsTitle" class="text-xl font-bold"></h2>
                <button id="closeDetailsBtn" class="text-white hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="p-6 space-y-6 max-h-[70vh] overflow-y-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 p-5 rounded-lg">
                        <h3 class="font-semibold text-lg text-[#4D44B5] mb-4">Informations de l'examen</h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Type</p>
                                <p id="detailType" class="text-gray-800 font-medium"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Date</p>
                                <p id="detailDate" class="text-gray-800 font-medium"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Lieu</p>
                                <p id="detailLieu" class="text-gray-800 font-medium"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Places max</p>
                                <p id="detailPlaces" class="text-gray-800 font-medium"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Statut</p>
                                <p id="detailStatut" class="text-gray-800 font-medium"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Candidat</p>
                                <p id="detailCandidat" class="text-gray-800 font-medium"></p>
                            </div>
                        </div>
                    </div>
                    
                    <div id="detailResults" class="bg-gray-50 p-5 rounded-lg">
                        <h3 class="font-semibold text-lg text-[#4D44B5] mb-4">Résultats</h3>
                        <!-- Contenu dynamique -->
                    </div>
                </div>
                
                <div class="bg-gray-50 p-5 rounded-lg">
                    <h3 class="font-semibold text-lg text-[#4D44B5] mb-3">Instructions</h3>
                    <p id="detailInstructions" class="text-gray-700 whitespace-pre-line"></p>
                </div>
                
                <div id="detailFeedbacks" class="bg-gray-50 p-5 rounded-lg">
                    <h3 class="font-semibold text-lg text-[#4D44B5] mb-3">Feedback</h3>
                    <!-- Contenu dynamique -->
                </div>
            </div>
            
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end">
                <button type="button" id="closeDetailsBtnBottom"
                    class="px-5 py-2.5 bg-[#4D44B5] text-white rounded-lg hover:bg-[#3a32a1] transition">
                    Fermer
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#examInstructions').on('input', function() {
        $('#charCount').text($(this).val().length);
    });

    $('#newExamBtn').click(function() {
        $('#modalExamTitle').text('Nouvel Examen');
        $('#examForm').attr('action', "{{ route('admin.exams.store') }}");
        $('#_method').val('POST');
        $('#examId').val('');
        $('#examForm')[0].reset();
        $('#charCount').text('0');
        $('#examModal').removeClass('hidden');
        $('body').addClass('overflow-hidden');
    });

    window.openEditModal = function(id, type, date, lieu, places, candidatId, instructions, statut) {
        $('#modalExamTitle').text('Modifier Examen');
        $('#examForm').attr('action', "{{ route('admin.exams.update', '') }}/" + id);
        $('#_method').val('PUT');
        $('#examId').val(id);
        
        $('#examType').val(type);
        $('#examDate').val(date);
        $('#examLieu').val(lieu);
        $('#examPlaces').val(places);
        $('#examStatut').val(statut);
        $('#examCandidat').val(candidatId || '');
        $('#examInstructions').val(instructions || '');
        $('#charCount').text(instructions ? instructions.length : 0);
        
        $('#examModal').removeClass('hidden');
        $('body').addClass('overflow-hidden');
    };

    window.openDetailsModal = function(id, type, date, lieu, places, statut, candidat, instructions, score, resultat, feedbacks, present) {
        $('#modalDetailsTitle').text('Détails de l\'Examen #' + id);
        $('#detailType').text(type.charAt(0).toUpperCase() + type.slice(1));
        $('#detailDate').text(date);
        $('#detailLieu').text(lieu);
        $('#detailPlaces').text(places);
        $('#detailStatut').text(statut.charAt(0).toUpperCase() + statut.slice(1).replace('_', ' '));
        $('#detailCandidat').text(candidat);
        $('#detailInstructions').text(instructions || 'Aucune instruction spécifiée');
        
        if(score && resultat && present !== '') {
            let resultatClass = '';
            let resultatText = resultat.replace('_', ' ').charAt(0).toUpperCase() + resultat.replace('_', ' ').slice(1);
            
            if(resultat === 'excellent') {
                resultatClass = 'bg-green-100 text-green-800';
            } else if(resultat === 'tres_bien') {
                resultatClass = 'bg-blue-100 text-blue-800';
            } else if(resultat === 'bien') {
                resultatClass = 'bg-indigo-100 text-indigo-800';
            } else if(resultat === 'moyen') {
                resultatClass = 'bg-yellow-100 text-yellow-800';
            } else {
                resultatClass = 'bg-red-100 text-red-800';
            }
            
            $('#detailResults').html(`
                <h3 class="font-semibold text-lg text-[#4D44B5] mb-4">Résultats</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Présence</p>
                        <p class="text-gray-800 font-medium">${present === '1' ? 'Présent' : 'Absent'}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Score</p>
                        <div class="w-full bg-gray-200 rounded-full h-2.5 mt-1">
                            <div class="bg-[#4D44B5] h-2.5 rounded-full" style="width: ${score}%"></div>
                        </div>
                        <p class="text-gray-800 font-medium mt-1">${score}/100</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Résultat</p>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full ${resultatClass}">
                            ${resultatText}
                        </span>
                    </div>
                </div>
            `);
            
            if(feedbacks && feedbacks.trim() !== '') {
                $('#detailFeedbacks').html(`
                    <h3 class="font-semibold text-lg text-[#4D44B5] mb-3">Feedback</h3>
                    <div class="bg-blue-50 p-3 rounded-lg">
                        <p class="text-gray-700 whitespace-pre-line">${feedbacks}</p>
                    </div>
                `);
            } else {
                $('#detailFeedbacks').html(`
                    <h3 class="font-semibold text-lg text-[#4D44B5] mb-3">Feedback</h3>
                    <p class="text-gray-500 italic">Aucun feedback disponible</p>
                `);
            }
        } else {
            $('#detailResults').html(`
                <h3 class="font-semibold text-lg text-[#4D44B5] mb-4">Résultats</h3>
                <p class="text-gray-500 italic">Aucun résultat enregistré</p>
            `);
            $('#detailFeedbacks').html(`
                <h3 class="font-semibold text-lg text-[#4D44B5] mb-3">Feedback</h3>
                <p class="text-gray-500 italic">Aucun feedback disponible</p>
            `);
        }
        
        $('#detailsModal').removeClass('hidden');
        $('body').addClass('overflow-hidden');
    };

    $('#cancelExamBtn, #cancelExamBtnBottom, #closeDetailsBtn, #closeDetailsBtnBottom').click(function() {
        $('#examModal, #detailsModal').addClass('hidden');
        $('body').removeClass('overflow-hidden');
    });

    $('form').on('submit', function(e) {
        var form = $(this);
        if (form[0].checkValidity() === false) {
            e.preventDefault();
            e.stopPropagation();
        }
        form.addClass('was-validated');
    });
    
    $('#examSearch').on('input', function() {
        let searchText = $(this).val().toLowerCase();
        $('tbody tr').each(function() {
            let rowText = $(this).text().toLowerCase();
            $(this).toggle(rowText.indexOf(searchText) > -1);
        });
    });
});
</script>

<style>
@media (max-width: 640px) {
    table, thead, tbody, th, td, tr {
        display: block;
    }
    
    thead tr {
        position: absolute;
        top: -9999px;
        left: -9999px;
    }
    
    tr {
        margin-bottom: 15px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
    }
    
    td {
        position: relative;
        padding: 12px 15px;
        padding-left: 15px;
        border-bottom: 1px solid #e2e8f0;
    }
    
    td:last-child {
        border-bottom: none;
    }
}
</style>
@endsection