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
        @if(session('success'))
            <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if($errors->any()))
            <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">Liste des Examens</h2>
                <div class="relative">
                    <input type="text" id="examSearch" placeholder="Rechercher..." 
                        class="pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]">
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
                                <button onclick="openEditModal(
                                    '{{ $exam->id }}',
                                    '{{ $exam->type }}',
                                    '{{ $exam->date_exam->format('Y-m-d\TH:i') }}',
                                    '{{ $exam->lieu }}',
                                    '{{ $exam->places_max }}',
                                    '{{ $exam->candidat_id }}',
                                    '{{ $exam->instructions }}',
                                    '{{ $exam->statut }}'
                                )" class="text-[#4D44B5] hover:text-[#3a32a1] mr-3">
                                    <i class="fas fa-edit"></i>
                                </button>
                                
                                @if($exam->candidat)
                                <button onclick="openResultModal(
                                    '{{ $exam->id }}',
                                    '{{ $exam->candidat_id }}',
                                    '{{ $exam->candidat->prenom }} {{ $exam->candidat->nom }}',
                                    '{{ $exam->type }}',
                                    '{{ $exam->date_exam->format('d/m/Y H:i') }}',
                                    '{{ $exam->lieu }}'
                                )" class="text-green-500 hover:text-green-700 mr-3">
                                    <i class="fas fa-check-circle"></i>
                                </button>
                                @endif
                                
                                <button onclick="openDetailsModal(
                                    '{{ $exam->id }}',
                                    '{{ $exam->type }}',
                                    '{{ $exam->date_exam->format('d/m/Y H:i') }}',
                                    '{{ $exam->lieu }}',
                                    '{{ $exam->places_max }}',
                                    '{{ $exam->statut }}',
                                    '{{ $exam->candidat ? $exam->candidat->prenom . ' ' . $exam->candidat->nom : 'Non assigné' }}',
                                    '{{ $exam->instructions }}',
                                    '{{ optional($exam->participants->first()->pivot)->score ?? '' }}',
                                    '{{ optional($exam->participants->first()->pivot)->resultat ?? '' }}',
                                    '{{ optional($exam->participants->first()->pivot)->feedbacks ?? '' }}',
                                    '{{ optional($exam->participants->first()->pivot)->present ?? '' }}'
                                )" class="text-purple-500 hover:text-purple-700 mr-3">
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
            </div>
            
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $exams->appends(request()->query())->links() }}
            </div>
        </div>
    </main>

    <div id="examModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50">
        <div class="bg-white w-full max-w-md p-6 rounded-lg">
            <h2 id="modalExamTitle" class="text-lg font-bold mb-4">Nouvel Examen</h2>
            <form id="examForm" method="POST">
                @csrf
                <input type="hidden" id="examId" name="id">
                <input type="hidden" id="_method" name="_method" value="POST">
                
                <div class="mb-4">
                    <label for="examType" class="block text-sm font-medium text-gray-700 mb-1">Type *</label>
                    <select id="examType" name="type" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                        <option value="">Sélectionnez un type</option>
                        <option value="theorique">Théorique</option>
                        <option value="pratique">Pratique</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label for="examDate" class="block text-sm font-medium text-gray-700 mb-1">Date et heure *</label>
                    <input type="datetime-local" id="examDate" name="date_exam" 
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required
                           min="{{ now()->format('Y-m-d\TH:i') }}">
                </div>
                
                <div class="mb-4">
                    <label for="examLieu" class="block text-sm font-medium text-gray-700 mb-1">Lieu *</label>
                    <input type="text" id="examLieu" name="lieu" maxlength="100"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="examPlaces" class="block text-sm font-medium text-gray-700 mb-1">Places max *</label>
                        <input type="number" id="examPlaces" name="places_max" min="1" max="50"
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="examStatut" class="block text-sm font-medium text-gray-700 mb-1">Statut *</label>
                        <select id="examStatut" name="statut" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                            <option value="planifie">Planifié</option>
                            <option value="en_cours">En cours</option>
                            <option value="termine">Terminé</option>
                            <option value="annule">Annulé</option>
                        </select>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="examCandidat" class="block text-sm font-medium text-gray-700 mb-1">Candidat</label>
                    <select id="examCandidat" name="candidat_id" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]">
                        <option value="">Non assigné</option>
                        @foreach($candidats as $candidat)
                            <option value="{{ $candidat->id }}">
                                {{ $candidat->prenom }} {{ $candidat->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-4">
                    <label for="examInstructions" class="block text-sm font-medium text-gray-700 mb-1">Instructions</label>
                    <textarea id="examInstructions" name="instructions" rows="3"
                              class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]"
                              maxlength="500"></textarea>
                    <small class="text-muted"><span id="charCount">0</span>/500 caractères</small>
                </div>
                
                <div class="flex justify-end space-x-2">
                    <button type="button" id="cancelExamBtn"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                        Annuler
                    </button>
                    <button type="submit" id="submitExamBtn"
                        class="px-4 py-2 bg-[#4D44B5] text-white rounded-lg hover:bg-[#3a32a1] transition">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="resultModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50">
        <div class="bg-white w-full max-w-md p-6 rounded-lg">
            <h2 id="modalResultTitle" class="text-lg font-bold mb-4">Saisie des Résultats</h2>
            <form id="resultForm" method="POST">
                @csrf
                <input type="hidden" id="resultExamId" name="exam_id">
                <input type="hidden" id="resultCandidatId" name="candidat_id">
                <input type="hidden" id="resultMethod" name="_method" value="POST">
                
                <div class="mb-4 p-3 bg-blue-50 rounded-lg">
                    <h4 class="font-medium text-blue-800" id="examInfoTitle"></h4>
                    <p class="text-sm text-blue-600" id="examInfoDetails"></p>
                    <p class="text-sm text-blue-600" id="examInfoCandidat"></p>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Présent *</label>
                    <div class="flex space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="present" value="1" checked class="form-radio text-[#4D44B5]">
                            <span class="ml-2">Oui</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="present" value="0" class="form-radio text-[#4D44B5]">
                            <span class="ml-2">Non</span>
                        </label>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="resultScore" class="block text-sm font-medium text-gray-700 mb-1">Score *</label>
                        <input type="number" id="resultScore" name="score" min="0" max="100"
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="resultResultat" class="block text-sm font-medium text-gray-700 mb-1">Résultat *</label>
                        <select id="resultResultat" name="resultat" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                            <option value="">Sélectionnez</option>
                            <option value="excellent">Excellent</option>
                            <option value="tres_bien">Très bien</option>
                            <option value="bien">Bien</option>
                            <option value="moyen">Moyen</option>
                            <option value="insuffisant">Insuffisant</option>
                        </select>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="resultFeedbacks" class="block text-sm font-medium text-gray-700 mb-1">Feedbacks</label>
                    <textarea id="resultFeedbacks" name="feedbacks" rows="3"
                              class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]"></textarea>
                </div>
                
                <div class="flex justify-end space-x-2">
                    <button type="button" id="cancelResultBtn"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                        Annuler
                    </button>
                    <button type="submit" id="submitResultBtn"
                        class="px-4 py-2 bg-[#4D44B5] text-white rounded-lg hover:bg-[#3a32a1] transition">
                        Enregistrer
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
                        <h3 class="font-semibold text-lg text-[#4D44B5] mb-4">Résultats</h3>
                        <div id="detailResults" class="space-y-3">
                            <p class="text-gray-500 italic">Aucun résultat enregistré</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 p-5 rounded-lg">
                    <h3 class="font-semibold text-lg text-[#4D44B5] mb-3">Instructions</h3>
                    <p id="detailInstructions" class="text-gray-700 whitespace-pre-line"></p>
                </div>
                
                <div class="bg-gray-50 p-5 rounded-lg">
                    <h3 class="font-semibold text-lg text-[#4D44B5] mb-3">Feedbacks</h3>
                    <p id="detailFeedbacks" class="text-gray-700 whitespace-pre-line italic">Aucun feedback enregistré</p>
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

    window.openResultModal = function(examId, candidatId, candidatName, examType, examDate, examLieu) {
        $('#modalResultTitle').text('Saisie des Résultats');
        $('#examInfoTitle').text('Examen: ' + examType.charAt(0).toUpperCase() + examType.slice(1));
        $('#examInfoDetails').text('Date: ' + examDate + ' | Lieu: ' + examLieu);
        $('#examInfoCandidat').text('Candidat: ' + candidatName);
        
        $.get("{{ route('admin.exams.results.check', ['exam' => ':examId', 'candidat' => ':candidatId']) }}"
            .replace(':examId', examId)
            .replace(':candidatId', candidatId), 
        function(data) {
            if(data.exists) {
                $('#resultForm').attr('action', "{{ route('admin.exams.results.update', ['exam' => ':examId', 'candidat' => ':candidatId']) }}"
                    .replace(':examId', examId)
                    .replace(':candidatId', candidatId));
                $('#resultMethod').val('PUT');
                $('input[name="present"][value="' + (data.result.present ? 1 : 0) + '"]').prop('checked', true);
                $('#resultScore').val(data.result.score);
                $('#resultResultat').val(data.result.resultat);
                $('#resultFeedbacks').val(data.result.feedbacks || '');
            } else {
                $('#resultForm').attr('action', "{{ route('admin.exams.results.store', ['exam' => ':examId']) }}"
                    .replace(':examId', examId));
                $('#resultMethod').val('POST');
                $('input[name="present"][value="1"]').prop('checked', true);
                $('#resultScore').val('');
                $('#resultResultat').val('');
                $('#resultFeedbacks').val('');
            }
            
            $('#resultExamId').val(examId);
            $('#resultCandidatId').val(candidatId);
            $('#resultModal').removeClass('hidden');
        });
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
        
        if(score && resultat) {
            $('#detailResults').html(`
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Présence</p>
                        <p class="text-gray-800 font-medium">${present ? 'Présent' : 'Absent'}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Score</p>
                        <div class="w-full bg-gray-200 h-2.5 mt-1">
                            <div class="bg-[#4D44B5] h-2.5 " style="width: ${score}%"></div>
                        </div>
                        <p class="text-gray-800 font-medium mt-1">${score}/100</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Résultat</p>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full 
                            ${resultat === 'excellent' ? 'bg-green-100 text-green-800' : 
                             resultat === 'tres_bien' ? 'bg-blue-100 text-blue-800' :
                             resultat === 'bien' ? 'bg-indigo-100 text-indigo-800' :
                             resultat === 'moyen' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800'}">
                            ${resultat.replace('_', ' ').charAt(0).toUpperCase() + resultat.replace('_', ' ').slice(1)}
                        </span>
                    </div>
                </div>
            `);
            
            if(feedbacks) {
                $('#detailFeedbacks').removeClass('italic').text(feedbacks);
            } else {
                $('#detailFeedbacks').addClass('italic').text('Aucun feedback enregistré');
            }
        } else {
            $('#detailResults').html('<p class="text-gray-500 italic">Aucun résultat enregistré</p>');
            $('#detailFeedbacks').addClass('italic').text('Aucun feedback enregistré');
        }
        
        $('#detailsModal').removeClass('hidden');
    };

    $('#cancelExamBtn, #cancelResultBtn, #closeDetailsBtn, #closeDetailsBtnBottom').click(function() {
        $('#examModal, #resultModal, #detailsModal').addClass('hidden');
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