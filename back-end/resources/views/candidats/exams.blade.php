@extends('layouts.candidats')

@section('content')
<div class="flex-1 overflow-auto">
    <header class="bg-[#4D44B5] text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <h1 class="text-2xl font-bold">Mes Examens</h1>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(session('success'))
            <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Examens Planifiés</h2>
            
            @if($plannedExams->isEmpty())
                <p class="text-gray-500">Aucun examen planifié pour le moment.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lieu</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($plannedExams as $exam)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                        {{ $exam->type === 'theorique' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                        {{ ucfirst($exam->type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $exam->date_exam->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $exam->lieu }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                        {{ $exam->statut === 'planifie' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ ucfirst(str_replace('_', ' ', $exam->statut)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button onclick="openPlanningModal(
                                        '{{ $exam->id }}',
                                        '{{ $exam->type }}',
                                        '{{ $exam->date_exam->format('d/m/Y H:i') }}',
                                        '{{ $exam->lieu }}',
                                        '{{ $exam->places_max }}',
                                        '{{ $exam->statut }}',
                                        '{{ $exam->instructions }}'
                                    )" class="text-[#4D44B5] hover:text-[#3a32a1]">
                                        <i class="fas fa-eye mr-1"></i> Détails
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Résultats des Examens</h2>
            
            @if($completedExams->isEmpty())
                <p class="text-gray-500">Aucun résultat d'examen disponible.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Score</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($completedExams as $exam)
                            @php
                                $result = $exam->participants->first()->pivot ?? null;
                            @endphp
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                        {{ $exam->type === 'theorique' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                        {{ ucfirst($exam->type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $exam->date_exam->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($result)
                                        <div class="flex items-center">
                                            <div class="w-full bg-gray-200 rounded-full h-2.5 mr-2">
                                                <div class="bg-[#4D44B5] h-2.5 rounded-full" 
                                                     style="width: {{ $result->score }}%"></div>
                                            </div>
                                            <span class="text-sm font-medium">{{ $result->score }}/100</span>
                                        </div>
                                    @else
                                        <span class="text-gray-500">N/A</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button onclick="openResultsModal(
                                        '{{ $exam->id }}',
                                        '{{ $exam->type }}',
                                        '{{ $exam->date_exam->format('d/m/Y H:i') }}',
                                        '{{ $exam->lieu }}',
                                        '{{ $exam->statut }}',
                                        '{{ $result ? $result->score : '' }}',
                                        '{{ $result ? $result->resultat : '' }}',
                                        `{{ $result ? $result->feedbacks : '' }}`,
                                        '{{ $result ? $result->present : '' }}'
                                    )" class="text-[#4D44B5] hover:text-[#3a32a1]">
                                        <i class="fas fa-eye mr-1"></i> Détails
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </main>

    <div id="planningModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50 p-4">
        <div class="bg-white w-full max-w-2xl rounded-xl shadow-xl overflow-hidden">
            <div class="bg-[#4D44B5] text-white px-6 py-4 flex justify-between items-center">
                <h2 id="modalPlanningTitle" class="text-xl font-bold">Détails de la Planification</h2>
                <button id="closePlanningBtn" class="text-white hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="p-6 space-y-6 max-h-[70vh] overflow-y-auto">
                <div class="grid grid-cols-1 gap-6">
                    
                    <div class="bg-gray-50 p-5 rounded-lg">
                        <h3 class="font-semibold text-lg text-[#4D44B5] mb-4">Informations de l'examen</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Type</p>
                                <p id="planningType" class="text-gray-800 font-medium"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Date</p>
                                <p id="planningDate" class="text-gray-800 font-medium"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Lieu</p>
                                <p id="planningLieu" class="text-gray-800 font-medium"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Places disponibles</p>
                                <p id="planningPlaces" class="text-gray-800 font-medium"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Statut</p>
                                <p id="planningStatut" class="text-gray-800 font-medium"></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 p-5 rounded-lg">
                        <h3 class="font-semibold text-lg text-[#4D44B5] mb-3">Instructions</h3>
                        <p id="planningInstructions" class="text-gray-700 whitespace-pre-line"></p>
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end">
                <button type="button" id="closePlanningBtnBottom"
                    class="px-4 py-2 bg-[#4D44B5] text-white rounded-lg hover:bg-[#3a32a1] transition">
                    Fermer
                </button>
            </div>
        </div>
    </div>

    <div id="resultsModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50 p-4">
        <div class="bg-white w-full max-w-2xl rounded-xl shadow-xl overflow-hidden">
            <div class="bg-[#4D44B5] text-white px-6 py-4 flex justify-between items-center">
                <h2 id="modalResultsTitle" class="text-xl font-bold">Résultats de l'Examen</h2>
                <button id="closeResultsBtn" class="text-white hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="p-6 space-y-6 max-h-[70vh] overflow-y-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 p-5 rounded-lg">
                        <h3 class="font-semibold text-lg text-[#4D44B5] mb-4">Informations</h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Type</p>
                                <p id="resultType" class="text-gray-800 font-medium"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Date</p>
                                <p id="resultDate" class="text-gray-800 font-medium"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Lieu</p>
                                <p id="resultLieu" class="text-gray-800 font-medium"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Statut</p>
                                <p id="resultStatut" class="text-gray-800 font-medium"></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 p-5 rounded-lg">
                        <h3 class="font-semibold text-lg text-[#4D44B5] mb-4">Votre Performance</h3>
                        <div id="resultDetails" class="space-y-3">
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 p-5 rounded-lg">
                    <h3 class="font-semibold text-lg text-[#4D44B5] mb-3">Feedbacks</h3>
                    <p id="resultFeedbacks" class="text-gray-700 whitespace-pre-line italic">Aucun feedback enregistré</p>
                </div>
            </div>
            
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end">
                <button type="button" id="closeResultsBtnBottom"
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
    $('#closePlanningBtn, #closePlanningBtnBottom').click(function() {
        $('#planningModal').addClass('hidden');
    });
    
    $('#closeResultsBtn, #closeResultsBtnBottom').click(function() {
        $('#resultsModal').addClass('hidden');
    });
});


function openPlanningModal(id, type, date, lieu, places, statut, instructions) {
    $('#modalPlanningTitle').text('Planification Examen #' + id);
    $('#planningType').text(type.charAt(0).toUpperCase() + type.slice(1));
    $('#planningDate').text(date);
    $('#planningLieu').text(lieu);
    $('#planningPlaces').text(places);
    $('#planningStatut').text(statut.charAt(0).toUpperCase() + statut.slice(1).replace('_', ' '));
    $('#planningInstructions').text(instructions || 'Aucune instruction spécifiée');
    
    $('#planningModal').removeClass('hidden');
}


function openResultsModal(id, type, date, lieu, statut, score, resultat, feedbacks, present) {
    $('#modalResultsTitle').text('Résultats Examen #' + id);
    $('#resultType').text(type.charAt(0).toUpperCase() + type.slice(1));
    $('#resultDate').text(date);
    $('#resultLieu').text(lieu);
    $('#resultStatut').text(statut.charAt(0).toUpperCase() + statut.slice(1).replace('_', ' '));

    updateResultsSection(score, resultat, present);
    
    updateFeedbacksSection(feedbacks);
    
    $('#resultsModal').removeClass('hidden');
}

function updateResultsSection(score, resultat, present) {
    const $resultsContainer = $('#resultDetails');
    
    if (score && resultat && present !== '') {
        $resultsContainer.html(`
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
                    <span class="px-3 py-1 text-xs font-semibold rounded-full ${getResultColorClass(resultat)}">
                        ${formatResultText(resultat)}
                    </span>
                </div>
            </div>
        `);
    } else {
        $resultsContainer.html('<p class="text-gray-500 italic">Aucun résultat enregistré</p>');
    }
}


function updateFeedbacksSection(feedbacks) {
    const $feedbacksContainer = $('#resultFeedbacks');
    
    if (feedbacks && feedbacks.trim() !== '') {
        $feedbacksContainer.html(`
            <div class="bg-blue-50 p-3 rounded-lg">
                <p class="text-gray-700 whitespace-pre-line">${feedbacks}</p>
            </div>
        `);
    } else {
        $feedbacksContainer.html('<p class="text-gray-500 italic">Aucun feedback disponible</p>');
    }
}


function getResultColorClass(resultat) {
    const colorMap = {
        'excellent': 'bg-green-100 text-green-800',
        'tres_bien': 'bg-blue-100 text-blue-800',
        'bien': 'bg-indigo-100 text-indigo-800',
        'moyen': 'bg-yellow-100 text-yellow-800',
        'insuffisant': 'bg-red-100 text-red-800'
    };
    return colorMap[resultat] || 'bg-gray-100 text-gray-800';
}


function formatResultText(resultat) {
    if (!resultat) return 'Non évalué';
    return resultat.replace('_', ' ')
                  .split(' ')
                  .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                  .join(' ');
}
</script>
@endsection