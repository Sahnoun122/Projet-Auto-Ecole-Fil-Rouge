@extends('layouts.candidats')

@php
if (!function_exists('getResultColorClass')) {
    function getResultColorClass($resultat) {
        $colorMap = [
            'excellent' => 'bg-green-100 text-green-800',
            'tres_bien' => 'bg-blue-100 text-blue-800',
            'bien' => 'bg-indigo-100 text-indigo-800',
            'moyen' => 'bg-yellow-100 text-yellow-800',
            'insuffisant' => 'bg-red-100 text-red-800',
            'reussi' => 'bg-green-100 text-green-800',
            'echoue' => 'bg-red-100 text-red-800'
        ];
        return $colorMap[$resultat] ?? 'bg-gray-100 text-gray-800';
    }
}

if (!function_exists('formatResultText')) {
    function formatResultText($resultat) {
        if (!$resultat) return 'Non évalué';
        return ucwords(str_replace('_', ' ', $resultat));
    }
}
@endphp

@section('content')
<div class="container mx-auto px-4 py-8">
    <header class="bg-[#4D44B5] text-white shadow-md rounded-lg mb-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col sm:flex-row justify-between items-center gap-3">
            <h1 class="text-xl sm:text-2xl font-bold text-center sm:text-left">Mes Examens</h1>
        </div>
    </header>

    <main class="space-y-12">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Examens Planifiés</h2>
            @if($plannedExams->isEmpty())
                <p class="text-gray-500 italic">Aucun examen planifié pour le moment.</p>
            @else
                <div class="">
                    <table class="min-w-full divide-y divide-gray-200 md:divide-y-0">
                        <thead class="bg-gray-50 hidden md:table-header-group">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Heure</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lieu</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($plannedExams as $exam)
                            <tr class="block md:table-row mb-4 border border-gray-200 rounded-lg md:border-none md:mb-0">
                                <td data-label="Type" class="block md:table-cell px-6 py-3 md:py-4 border-b border-gray-200 md:border-none relative md:static pl-32 md:pl-6 before:content-[attr(data-label)] before:absolute before:left-4 before:top-3 before:text-xs before:font-bold before:uppercase before:text-gray-500 md:before:content-none">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                        {{ $exam->type === 'theorique' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                        {{ ucfirst($exam->type) }}
                                    </span>
                                </td>
                                <td data-label="Date & Heure" class="block md:table-cell px-6 py-3 md:py-4 border-b border-gray-200 md:border-none relative md:static pl-32 md:pl-6 text-sm text-gray-700 before:content-[attr(data-label)] before:absolute before:left-4 before:top-3 before:text-xs before:font-bold before:uppercase before:text-gray-500 md:before:content-none">
                                    {{ $exam->date_exam->format('d/m/Y H:i') }}
                                </td>
                                <td data-label="Lieu" class="block md:table-cell px-6 py-3 md:py-4 border-b border-gray-200 md:border-none relative md:static pl-32 md:pl-6 text-sm text-gray-700 before:content-[attr(data-label)] before:absolute before:left-4 before:top-3 before:text-xs before:font-bold before:uppercase before:text-gray-500 md:before:content-none">
                                    {{ $exam->lieu }}
                                </td>
                                <td data-label="Statut" class="block md:table-cell px-6 py-3 md:py-4 border-b border-gray-200 md:border-none relative md:static pl-32 md:pl-6 before:content-[attr(data-label)] before:absolute before:left-4 before:top-3 before:text-xs before:font-bold before:uppercase before:text-gray-500 md:before:content-none">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        {{ ucfirst($exam->statut) }}
                                    </span>
                                </td>
                                <td data-label="Actions" class="block md:table-cell px-6 py-3 md:py-4 relative md:static pl-32 md:pl-6 text-sm font-medium before:content-[attr(data-label)] before:absolute before:left-4 before:top-3 before:text-xs before:font-bold before:uppercase before:text-gray-500 md:before:content-none">
                                    <button onclick="openPlanningModal(
                                        '{{ $exam->id }}',
                                        '{{ $exam->type }}',
                                        '{{ $exam->date_exam->format('d/m/Y H:i') }}',
                                        '{{ $exam->lieu }}',
                                        '{{ $exam->places_max }}',
                                        '{{ $exam->statut }}',
                                        '{{ $exam->instructions }}'
                                    )" class="text-[#4D44B5] hover:text-[#3a32a1]">
                                        <i class="fas fa-info-circle mr-1"></i> Détails
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Examens Terminés</h2>
            @if($completedExams->isEmpty())
                <p class="text-gray-500 italic">Aucun examen terminé.</p>
            @else
                <div class="">
                    <table class="min-w-full divide-y divide-gray-200 md:divide-y-0">
                        <thead class="bg-gray-50 hidden md:table-header-group">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lieu</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Résultat</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($completedExams as $exam)
                            @php
                                $result = $exam->result; 
                            @endphp
                            <tr class="block md:table-row mb-4 border border-gray-200 rounded-lg md:border-none md:mb-0">
                                <td data-label="Type" class="block md:table-cell px-6 py-3 md:py-4 border-b border-gray-200 md:border-none relative md:static pl-32 md:pl-6 before:content-[attr(data-label)] before:absolute before:left-4 before:top-3 before:text-xs before:font-bold before:uppercase before:text-gray-500 md:before:content-none">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                        {{ $exam->type === 'theorique' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                        {{ ucfirst($exam->type) }}
                                    </span>
                                </td>
                                <td data-label="Date" class="block md:table-cell px-6 py-3 md:py-4 border-b border-gray-200 md:border-none relative md:static pl-32 md:pl-6 text-sm text-gray-700 before:content-[attr(data-label)] before:absolute before:left-4 before:top-3 before:text-xs before:font-bold before:uppercase before:text-gray-500 md:before:content-none">
                                    {{ $exam->date_exam->format('d/m/Y H:i') }}
                                </td>
                                <td data-label="Lieu" class="block md:table-cell px-6 py-3 md:py-4 border-b border-gray-200 md:border-none relative md:static pl-32 md:pl-6 text-sm text-gray-700 before:content-[attr(data-label)] before:absolute before:left-4 before:top-3 before:text-xs before:font-bold before:uppercase before:text-gray-500 md:before:content-none">
                                    {{ $exam->lieu }}
                                </td>
                                <td data-label="Statut" class="block md:table-cell px-6 py-3 md:py-4 border-b border-gray-200 md:border-none relative md:static pl-32 md:pl-6 before:content-[attr(data-label)] before:absolute before:left-4 before:top-3 before:text-xs before:font-bold before:uppercase before:text-gray-500 md:before:content-none">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                        {{ ucfirst($exam->statut) }}
                                    </span>
                                </td>
                                <td data-label="Résultat" class="block md:table-cell px-6 py-3 md:py-4 border-b border-gray-200 md:border-none relative md:static pl-32 md:pl-6 before:content-[attr(data-label)] before:absolute before:left-4 before:top-3 before:text-xs before:font-bold before:uppercase before:text-gray-500 md:before:content-none">
                                    @if($result && isset($result->resultat) && $result->resultat !== null && $result->resultat !== '')
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ getResultColorClass($result->resultat) }}">
                                            {{ formatResultText($result->resultat) }}
                                        </span>
                                    @else
                                        <span class="text-gray-500 italic">Non évalué</span>
                                    @endif
                                </td>
                                <td data-label="Actions" class="block md:table-cell px-6 py-3 md:py-4 relative md:static pl-32 md:pl-6 text-sm font-medium space-x-2 before:content-[attr(data-label)] before:absolute before:left-4 before:top-3 before:text-xs before:font-bold before:uppercase before:text-gray-500 md:before:content-none">
                                    <button onclick="openResultsModal(
                                        '{{ $exam->id }}',
                                        '{{ $exam->type }}',
                                        '{{ $exam->date_exam->format('d/m/Y H:i') }}',
                                        '{{ $exam->lieu }}',
                                        '{{ $exam->statut }}',
                                        '{{ $result ? $result->score : '' }}',
                                        '{{ $result ? $result->resultat : '' }}',
                                        '{{ ($result && isset($result->present)) ? (int)$result->present : '' }}'
                                    )" class="text-[#4D44B5] hover:text-[#3a32a1]">
                                        <i class="fas fa-poll mr-1"></i> Voir Résultats
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
        <div class="bg-white w-full max-w-lg rounded-xl shadow-xl overflow-hidden">
            <div class="bg-[#4D44B5] text-white px-6 py-4 flex justify-between items-center">
                <h2 id="modalTitle" class="text-xl font-bold">Détails de l'Examen Planifié</h2>
                <button onclick="closePlanningModal()" class="text-white hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Type</p>
                    <p id="modalType" class="text-gray-800 font-medium"></p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Date et heure</p>
                    <p id="modalDate" class="text-gray-800 font-medium"></p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Lieu</p>
                    <p id="modalLieu" class="text-gray-800 font-medium"></p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Places Max</p>
                    <p id="modalPlaces" class="text-gray-800 font-medium"></p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Statut</p>
                    <p id="modalStatut" class="text-gray-800 font-medium"></p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Instructions</p>
                    <p id="modalInstructions" class="text-gray-800 whitespace-pre-line"></p>
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-4 flex justify-end">
                <button onclick="closePlanningModal()" class="px-4 py-2 bg-[#4D44B5] text-white rounded-md hover:bg-[#3a32a1]">
                    Fermer
                </button>
            </div>
        </div>
    </div>

    <div id="resultsModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50 p-4">
        <div class="bg-white w-full max-w-2xl rounded-xl shadow-xl overflow-hidden">
            <div class="bg-[#4D44B5] text-white px-6 py-4 flex justify-between items-center">
                <h2 id="modalResultsTitle" class="text-xl font-bold">Résultats de l'Examen</h2>
                <button onclick="closeResultsModal()" class="text-white hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Type d'examen</p>
                        <p id="resultType" class="text-gray-800 font-medium"></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Date et heure</p>
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
                
                <div class="border-t border-gray-200 pt-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Vos Résultats</h3>
                    <div id="resultDetails" class="space-y-3"></div>
                </div>
                
            </div>
            
            <div class="bg-gray-50 px-6 py-4 flex justify-end">
                <button onclick="closeResultsModal()" class="px-4 py-2 bg-[#4D44B5] text-white rounded-md hover:bg-[#3a32a1]">
                    Fermer
                </button>
            </div>
        </div>
    </div>

    <div id="feedbackModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50 p-4">
        <div class="bg-white w-full max-w-lg rounded-xl shadow-xl overflow-hidden">
            <div class="bg-[#4D44B5] text-white px-6 py-4 flex justify-between items-center">
                <h2 class="text-xl font-bold">Donner un Feedback</h2>
                <button onclick="closeFeedbackModal()" class="text-white hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="feedbackForm" class="p-6 space-y-4">
                @csrf
                <input type="hidden" id="feedbackExamId" name="exam_id">
                <input type="hidden" id="feedbackMethod" name="_method" value="POST">
                
                <div id="existingFeedbackSection" class="hidden mb-4">
                    <h3 class="text-md font-semibold text-gray-700 mb-2">Votre Feedback Précédent</h3>
                    <div class="bg-gray-100 p-3 rounded-lg">
                        <div class="flex items-center mb-2">
                            <span class="text-yellow-500 mr-2">Note:</span>
                            <div id="existingRatingStars" class="flex"></div>
                        </div>
                        <p class="text-gray-700 whitespace-pre-line" id="existingComment"></p>
                    </div>
                    <button type="button" onclick="deleteFeedback()" class="mt-2 text-sm text-red-600 hover:text-red-800">
                        <i class="fas fa-trash-alt mr-1"></i> Supprimer ce feedback
                    </button>
                </div>

                <div id="newFeedbackSection">
                    <div>
                        <label for="rating" class="block text-sm font-medium text-gray-700 mb-1">Note (sur 5)</label>
                        <div id="ratingStars" class="flex space-x-1 text-2xl text-gray-300 cursor-pointer">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star" data-value="{{ $i }}" onclick="highlightFeedbackStars({{ $i }})"></i>
                            @endfor
                        </div>
                        <input type="hidden" id="rating" name="rating" required>
                    </div>
                    <div>
                        <label for="comment" class="block text-sm font-medium text-gray-700">Commentaire</label>
                        <textarea id="comment" name="comment" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#4D44B5] focus:ring focus:ring-[#4D44B5] focus:ring-opacity-50"></textarea>
                    </div>
                </div>
                
                <div class="bg-gray-50 px-6 py-4 -mx-6 -mb-6 mt-6 flex justify-end">
                    <button type="button" onclick="closeFeedbackModal()" class="mr-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                        Annuler
                    </button>
                    <button type="submit" class="px-4 py-2 bg-[#4D44B5] text-white rounded-md hover:bg-[#3a32a1]">
                        <span id="feedbackSubmitButtonText">Soumettre</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="alert-container" class="fixed top-5 right-5 z-[100] space-y-2"></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#feedbackForm').on('submit', function(e) {
        e.preventDefault();
        const form = $(this);
        const examId = $('#feedbackExamId').val();
        const method = $('#feedbackMethod').val(); 
        let url = `{{ route('candidats.exams.feedback.store', '') }}/${examId}`;
        
        $.ajax({
            url: url,
            method: method,
            data: form.serialize(),
            success: function(response) {
                showAlert('success', response.message || 'Feedback soumis avec succès!');
                closeFeedbackModal();
            },
            error: function(xhr) {
                let errorMsg = 'Erreur lors de la soumission du feedback.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                showAlert('error', errorMsg);
            }
        });
    });
});

function openPlanningModal(id, type, date, lieu, places, statut, instructions) {
    $('#modalTitle').text('Détails Examen Planifié #' + id);
    $('#modalType').text(type.charAt(0).toUpperCase() + type.slice(1));
    $('#modalDate').text(date);
    $('#modalLieu').text(lieu);
    $('#modalPlaces').text(places);
    $('#modalStatut').text(statut.charAt(0).toUpperCase() + statut.slice(1));
    $('#modalInstructions').text(instructions || 'Aucune instruction');
    $('#planningModal').removeClass('hidden');
}

function closePlanningModal() {
    $('#planningModal').addClass('hidden');
}

function openResultsModal(id, type, date, lieu, statut, score, resultat, present) {
    $('#modalResultsTitle').text('Résultats Examen #' + id);
    $('#resultType').text(type.charAt(0).toUpperCase() + type.slice(1));
    $('#resultDate').text(date);
    $('#resultLieu').text(lieu);
    $('#resultStatut').text(statut.charAt(0).toUpperCase() + statut.slice(1).replace('_', ' '));

    updateResultsSection(score, resultat, present);
    
    $('#resultsModal').removeClass('hidden');
}

function closeResultsModal() {
    $('#resultsModal').addClass('hidden');
}

function updateResultsSection(score, resultat, present) {
    const $resultsContainer = $('#resultDetails');
    $resultsContainer.empty();

    if (present !== '') { 
        let contentHtml = `
            <div>
                <p class="text-sm text-gray-500 font-medium">Présence</p>
                <p class="text-gray-800 font-medium">${present === '1' ? 'Présent' : 'Absent'}</p>
            </div>
        `;

        if (score !== '') { 
            const scoreNum = parseFloat(score);
            contentHtml += `
                <div>
                    <p class="text-sm text-gray-500 font-medium">Score</p>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 mt-1">
                        <div class="bg-[#4D44B5] h-2.5 rounded-full" style="width: ${scoreNum}%"></div>
                    </div>
                    <p class="text-gray-800 font-medium mt-1">${scoreNum.toFixed(2)}/100</p>
                </div>
            `;
        }
        if (resultat !== '') { 
            contentHtml += `
                <div>
                    <p class="text-sm text-gray-500 font-medium">Résultat</p>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full ${getResultColorClass(resultat)}">
                        ${formatResultText(resultat)}
                    </span>
                </div>
            `;
        }
        
        $resultsContainer.html(`<div class="space-y-3">${contentHtml}</div>`);

    } else {
        $resultsContainer.html('<p class="text-gray-500 italic">Aucun résultat enregistré</p>');
    }
}

function openFeedbackModal(examId) {
    $('#feedbackExamId').val(examId);
    $('#feedbackForm')[0].reset(); 
    highlightFeedbackStars(0); 
    $('#feedbackMethod').val('POST'); 
    $('#feedbackSubmitButtonText').text('Soumettre');
    $('#existingFeedbackSection').addClass('hidden');
    $('#newFeedbackSection').removeClass('hidden');
    loadExistingFeedback(examId);
    $('#feedbackModal').removeClass('hidden');
}

function closeFeedbackModal() {
    $('#feedbackModal').addClass('hidden');
}

function loadExistingFeedback(examId) {
    $.ajax({
        url: `{{ route('candidats.exams.feedback', '') }}/${examId}`,
        method: 'GET',
        success: function(response) {
            if (response.feedback) {
                const feedback = response.feedback;
                $('#existingRatingStars').html(generateStarsHTML(feedback.rating));
                $('#existingComment').text(feedback.comment || 'Aucun commentaire');
                $('#existingFeedbackSection').removeClass('hidden');
                $('#newFeedbackSection').addClass('hidden');
                $('#feedbackMethod').val('DELETE'); 
                $('#feedbackSubmitButtonText').text('Modifier'); 
            } else {
                $('#existingFeedbackSection').addClass('hidden');
                $('#newFeedbackSection').removeClass('hidden');
                $('#feedbackMethod').val('POST');
                $('#feedbackSubmitButtonText').text('Soumettre');
            }
        },
        error: function() {
            console.error('Erreur lors du chargement du feedback existant.');
            $('#existingFeedbackSection').addClass('hidden');
            $('#newFeedbackSection').removeClass('hidden');
            $('#feedbackMethod').val('POST');
            $('#feedbackSubmitButtonText').text('Soumettre');
        }
    });
}

function deleteFeedback() {
    const examId = $('#feedbackExamId').val();
    if (!confirm('Êtes-vous sûr de vouloir supprimer votre feedback ?')) {
        return;
    }
    $.ajax({
        url: `{{ route('candidats.exams.feedback.destroy', '') }}/${examId}`,
        method: 'DELETE',
        data: { _token: '{{ csrf_token() }}' },
        success: function(response) {
            showAlert('success', response.message || 'Feedback supprimé avec succès!');
            $('#feedbackForm')[0].reset();
            highlightFeedbackStars(0);
            $('#existingFeedbackSection').addClass('hidden');
            $('#newFeedbackSection').removeClass('hidden');
            $('#feedbackMethod').val('POST');
            $('#feedbackSubmitButtonText').text('Soumettre');
        },
        error: function(xhr) {
            let errorMsg = 'Erreur lors de la suppression du feedback.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMsg = xhr.responseJSON.message;
            }
            showAlert('error', errorMsg);
        }
    });
}

function highlightFeedbackStars(rating) {
    $('#rating').val(rating);
    $('#ratingStars i').each(function(index) {
        if (index < rating) {
            $(this).removeClass('text-gray-300').addClass('text-yellow-400');
        } else {
            $(this).removeClass('text-yellow-400').addClass('text-gray-300');
        }
    });
}

function generateStarsHTML(rating) {
    let starsHtml = '';
    for (let i = 1; i <= 5; i++) {
        starsHtml += `<i class="fas fa-star ${i <= rating ? 'text-yellow-400' : 'text-gray-300'}"></i>`;
    }
    return starsHtml;
}

function getResultColorClass(resultat) {
    const colorMap = {
        'excellent': 'bg-green-100 text-green-800',
        'tres_bien': 'bg-blue-100 text-blue-800',
        'bien': 'bg-indigo-100 text-indigo-800',
        'moyen': 'bg-yellow-100 text-yellow-800',
        'insuffisant': 'bg-red-100 text-red-800',
        'reussi': 'bg-green-100 text-green-800', 
        'echoue': 'bg-red-100 text-red-800' 
    };
    return colorMap[resultat] || 'bg-gray-100 text-gray-800';
}

function formatResultText(resultat) {
    if (!resultat) return 'Non évalué';
    return resultat.charAt(0).toUpperCase() + resultat.slice(1).replace('_', ' ');
}

function showAlert(type, message) {
    const alertId = `alert-${Date.now()}`;
    const alertBg = type === 'success' ? 'bg-green-500' : 'bg-red-500';
    const alert = `
        <div id="${alertId}" class="${alertBg} text-white px-4 py-2 rounded-md shadow-lg flex justify-between items-center opacity-0 transform translate-x-full transition-all duration-300 ease-out">
            <span>${message}</span>
            <button onclick="document.getElementById('${alertId}').remove()" class="ml-4 text-xl font-bold">&times;</button>
        </div>
    `;
    $('#alert-container').append(alert);
    
    setTimeout(() => {
        $(`#${alertId}`).removeClass('opacity-0 translate-x-full').addClass('opacity-100 translate-x-0');
    }, 10);

    setTimeout(() => {
        $(`#${alertId}`).removeClass('opacity-100 translate-x-0').addClass('opacity-0 translate-x-full');
        setTimeout(() => $(`#${alertId}`).remove(), 300);
    }, 5000);
}
</script>
@endsection