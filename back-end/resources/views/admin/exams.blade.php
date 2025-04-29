@extends('layouts.admin')

@section('content')
<div class="flex-1 overflow-auto">
    <header class="bg-[#4D44B5] text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold">Gestion des Examens</h1>
            <button id="newExamBtn" class="bg-white text-[#4D44B5] px-4 py-2 rounded-lg font-medium hover:bg-gray-100 transition">
                <i class="fas fa-plus mr-2"></i> Nouvel Examen
            </button>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <h2 class="text-xl font-semibold text-gray-800">Liste des Examens</h2>
                <div class="relative w-full md:w-auto">
                    <input type="text" id="examSearch" placeholder="Rechercher..." 
                        class="pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] w-full">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
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
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs rounded-full 
                                    {{ $exam->type === 'theorique' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                    {{ ucfirst($exam->type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $exam->date_exam->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $exam->lieu }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($exam->candidat)
                                    <div class="font-medium text-[#4D44B5]">{{ $exam->candidat->prenom }} {{ $exam->candidat->nom }}</div>
                                @else
                                    <span class="text-gray-500">Non assigné</span>
                                @endif
                            </td>
                   
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs rounded-full 
                                    {{ $exam->statut === 'planifie' ? 'bg-yellow-100 text-yellow-800' : 
                                       ($exam->statut === 'en_cours' ? 'bg-blue-100 text-blue-800' : 
                                       ($exam->statut === 'termine' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800')) }}">
                                    {{ ucfirst(str_replace('_', ' ', $exam->statut)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <button onclick="openEditModal(
                                        '{{ $exam->id }}',
                                        '{{ $exam->type }}',
                                        '{{ $exam->date_exam->format('Y-m-d\TH:i') }}',
                                        '{{ $exam->lieu }}',
                                        '{{ $exam->places_max }}',
                                        '{{ $exam->candidat_id }}',
                                        '{{ $exam->instructions }}',
                                        '{{ $exam->statut }}'
                                    )" class="text-[#4D44B5] hover:text-[#3a32a1] p-1 rounded hover:bg-gray-100">
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
                                    )" class="text-purple-500 hover:text-purple-700 p-1 rounded hover:bg-gray-100">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    
                                    <form action="{{ route('admin.exams.destroy', $exam->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet examen ?')"
                                            class="text-red-500 hover:text-red-700 p-1 rounded hover:bg-gray-100">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                Aucun examen programmé
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $exams->appends(request()->query())->links() }}
            </div>
        </div>
    </main>

    <div id="examModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50 p-4">
        <div class="bg-white w-full max-w-md rounded-lg shadow-xl">
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
                        <select id="examType" name="type" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-[#4D44B5]" required>
                            <option value="">Sélectionnez un type</option>
                            <option value="theorique">Théorique</option>
                            <option value="pratique">Pratique</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="examDate" class="block text-sm font-medium text-gray-700 mb-1">Date et heure *</label>
                        <input type="datetime-local" id="examDate" name="date_exam" 
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-[#4D44B5]" required
                               min="{{ now()->format('Y-m-d\TH:i') }}">
                    </div>
                    
                    <div>
                        <label for="examLieu" class="block text-sm font-medium text-gray-700 mb-1">Lieu *</label>
                        <input type="text" id="examLieu" name="lieu" maxlength="100"
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-[#4D44B5]" required>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="examPlaces" class="block text-sm font-medium text-gray-700 mb-1">Places max *</label>
                            <input type="number" id="examPlaces" name="places_max" min="1" max="50"
                                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-[#4D44B5]" required>
                        </div>
                        
                        <div>
                            <label for="examStatut" class="block text-sm font-medium text-gray-700 mb-1">Statut *</label>
                            <select id="examStatut" name="statut" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-[#4D44B5]" required>
                                <option value="planifie">Planifié</option>
                                <option value="en_cours">En cours</option>
                                <option value="termine">Terminé</option>
                                <option value="annule">Annulé</option>
                            </select>
                        </div>
                    </div>
                    
                    <div>
                        <label for="examCandidat" class="block text-sm font-medium text-gray-700 mb-1">Candidat</label>
                        <select id="examCandidat" name="candidat_id" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-[#4D44B5]">
                            <option value="">Non assigné</option>
                            @foreach($candidats as $candidat)
                                <option value="{{ $candidat->id }}">
                                    {{ $candidat->prenom }} {{ $candidat->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label for="examInstructions" class="block text-sm font-medium text-gray-700 mb-1">Instructions</label>
                        <textarea id="examInstructions" name="instructions" rows="3"
                                  class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-[#4D44B5]"
                                  maxlength="500"></textarea>
                        <small class="text-gray-500 text-xs"><span id="charCount">0</span>/500 caractères</small>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" id="cancelExamBtnBottom"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                        Annuler
                    </button>
                    <button type="submit" id="submitExamBtn"
                        class="px-4 py-2 bg-[#4D44B5] text-white rounded-lg hover:bg-[#3a32a1] transition flex items-center">
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
                    
         
                
                <div class="bg-gray-50 p-5 rounded-lg">
                    <h3 class="font-semibold text-lg text-[#4D44B5] mb-3">Instructions</h3>
                    <p id="detailInstructions" class="text-gray-700 whitespace-pre-line"></p>
                </div>
                
                <div class="bg-gray-50 p-5 rounded-lg">
                </div>
            </div>
            
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end">
                <button type="button" id="closeDetailsBtnBottom"
                    class="px-4 py-2 bg-[#4D44B5] text-white rounded-lg hover:bg-[#3a32a1] transition">
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
            
            // Section Feedbacks
            if(feedbacks && feedbacks.trim() !== '') {
                $('#detailFeedbacks').html(`
                    <div class="bg-blue-50 p-3 rounded-lg">
                        <p class="text-gray-700 whitespace-pre-line">${feedbacks}</p>
                    </div>
                `);
            } else {
                $('#detailFeedbacks').html('<p class="text-gray-500 italic">Aucun feedback disponible</p>');
            }
        } else {
            $('#detailResults').html('<p class="text-gray-500 italic">Aucun résultat enregistré</p>');
            $('#detailFeedbacks').html('<p class="text-gray-500 italic">Aucun feedback disponible</p>');
        }
        
        $('#detailsModal').removeClass('hidden');
    };

    $('#cancelExamBtn, #cancelExamBtnBottom, #closeDetailsBtn, #closeDetailsBtnBottom').click(function() {
        $('#examModal, #detailsModal').addClass('hidden');
    });

    $('form').on('submit', function(e) {
        var form = $(this);
        if (form[0].checkValidity() === false) {
            e.preventDefault();
            e.stopPropagation();
        }
        form.addClass('was-validated');
    });
});
</script>
@endsection