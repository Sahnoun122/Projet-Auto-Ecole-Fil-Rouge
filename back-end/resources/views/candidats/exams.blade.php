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
                                    )" class="text-[#4D44B5] hover:text-[#3a32a1] mr-2">
                                        <i class="fas fa-eye mr-1"></i> Résultats
                                    </button>
                                    <button onclick="openFeedbackModal('{{ $exam->id }}')" 
                                        class="text-purple-600 hover:text-purple-800">
                                        <i class="fas fa-comment mr-1"></i> Feedback
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

    <!-- Modal Planification Examen -->
    <div id="planningModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50 p-4">
        <div class="bg-white w-full max-w-2xl rounded-xl shadow-xl overflow-hidden">
            <div class="bg-[#4D44B5] text-white px-6 py-4 flex justify-between items-center">
                <h2 id="modalPlanningTitle" class="text-xl font-bold">Détails de l'Examen</h2>
                <button onclick="closePlanningModal()" class="text-white hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Type d'examen</p>
                        <p id="planningType" class="text-gray-800 font-medium"></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Date et heure</p>
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
                
                <div>
                    <p class="text-sm text-gray-500 font-medium">Instructions</p>
                    <p id="planningInstructions" class="text-gray-800 mt-1 whitespace-pre-line"></p>
                </div>
            </div>
            
            <div class="bg-gray-50 px-6 py-4 flex justify-end">
                <button onclick="closePlanningModal()" class="px-4 py-2 bg-[#4D44B5] text-white rounded-md hover:bg-[#3a32a1]">
                    Fermer
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Résultats Examen -->
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
                
                <div class="border-t border-gray-200 pt-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Feedback du Moniteur</h3>
                    <div id="resultFeedbacks" class="space-y-3"></div>
                </div>
            </div>
            
            <div class="bg-gray-50 px-6 py-4 flex justify-end">
                <button onclick="closeResultsModal()" class="px-4 py-2 bg-[#4D44B5] text-white rounded-md hover:bg-[#3a32a1]">
                    Fermer
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Feedback Candidat -->
    <div id="feedbackModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50 p-4">
        <div class="bg-white w-full max-w-2xl rounded-xl shadow-xl overflow-hidden">
            <div class="bg-[#4D44B5] text-white px-6 py-4 flex justify-between items-center">
                <h2 id="modalFeedbackTitle" class="text-xl font-bold">Votre Feedback</h2>
                <button onclick="closeFeedbackModal()" class="text-white hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="p-6 space-y-6 max-h-[70vh] overflow-y-auto">
                <div id="existingFeedbackContainer" class="hidden bg-blue-50 p-4 rounded-lg mb-4 border border-blue-200">
                    <h3 class="font-semibold text-blue-800 mb-2">Votre feedback existant</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Feedback sur l'examen</p>
                            <p id="existingExamFeedback" class="text-gray-800 mt-1 whitespace-pre-line"></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Commentaire sur l'école</p>
                            <p id="existingSchoolComment" class="text-gray-800 mt-1 whitespace-pre-line"></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Note à l'école</p>
                            <div id="existingSchoolRating" class="flex mt-1"></div>
                        </div>
                    </div>
                    <div class="mt-4 flex justify-end">
                        <button onclick="deleteFeedback()" class="text-red-600 hover:text-red-800 text-sm">
                            <i class="fas fa-trash mr-1"></i> Supprimer ce feedback
                        </button>
                    </div>
                </div>
                
                <form id="feedbackForm" class="space-y-4">
                    @csrf
                    <input type="hidden" id="feedbackExamId" name="exam_id">
                    
                    <div>
                        <label for="examFeedbackInput" class="block text-sm font-medium text-gray-700 mb-1">
                            Votre feedback sur l'examen (optionnel)
                        </label>
                        <textarea id="examFeedbackInput" name="exam_feedback" rows="3" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#4D44B5] focus:border-[#4D44B5]"></textarea>
                    </div>
                    
                    <div>
                        <label for="schoolCommentInput" class="block text-sm font-medium text-gray-700 mb-1">
                            Votre commentaire sur l'école (optionnel)
                        </label>
                        <textarea id="schoolCommentInput" name="school_comment" rows="3" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#4D44B5] focus:border-[#4D44B5]"></textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Notez votre expérience avec l'école (1-5 étoiles)
                        </label>
                        <div class="flex items-center">
                            <div id="starRatingInput" class="flex">
                                @for($i = 1; $i <= 5; $i++)
                                <svg class="w-8 h-8 cursor-pointer star-rating" data-rating="{{ $i }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                @endfor
                            </div>
                            <input type="hidden" id="schoolRatingInput" name="school_rating" value="0">
                            <span id="ratingTextInput" class="ml-2 text-sm text-gray-500">0 étoiles</span>
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-3 pt-2">
                        <button type="button" onclick="closeFeedbackModal()" 
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            Annuler
                        </button>
                        <button type="submit" 
                            class="px-4 py-2 bg-[#4D44B5] text-white rounded-md hover:bg-[#3a32a1]">
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Gestion des modals
    $('.star-rating').hover(function() {
        const rating = $(this).data('rating');
        highlightFeedbackStars(rating);
    }, function() {
        const currentRating = $('#schoolRatingInput').val();
        highlightFeedbackStars(currentRating);
    });
    
    $('.star-rating').click(function() {
        const rating = $(this).data('rating');
        $('#schoolRatingInput').val(rating);
        $('#ratingTextInput').text(rating + (rating > 1 ? ' étoiles' : ' étoile'));
    });
    
    // Soumission du formulaire de feedback
    $('#feedbackForm').submit(function(e) {
        e.preventDefault();
        
        const examId = $('#feedbackExamId').val();
        const formData = $(this).serialize();
        
        $.ajax({
            url: `/candidats/exams/${examId}/feedback`,
            method: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.success) {
                    loadExistingFeedback(examId);
                    
                    $('#examFeedbackInput').val('');
                    $('#schoolCommentInput').val('');
                    $('#schoolRatingInput').val('0');
                    $('.star-rating').removeClass('text-yellow-400').addClass('text-gray-300');
                    $('#ratingTextInput').text('0 étoiles');
                    
                    showAlert('success', 'Votre feedback a été enregistré avec succès!');
                }
            },
            error: function(xhr) {
                showAlert('error', 'Une erreur est survenue lors de l\'envoi du feedback.');
                console.error(xhr.responseText);
            }
        });
    });
});

// Fonctions pour la modal de planification
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

function closePlanningModal() {
    $('#planningModal').addClass('hidden');
}

// Fonctions pour la modal de résultats
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

function closeResultsModal() {
    $('#resultsModal').addClass('hidden');
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

// Fonctions pour la modal de feedback
function openFeedbackModal(examId) {
    $('#feedbackExamId').val(examId);
    $('#modalFeedbackTitle').text(`Feedback pour l'examen #${examId}`);
    
    $('#examFeedbackInput').val('');
    $('#schoolCommentInput').val('');
    $('#schoolRatingInput').val('0');
    $('.star-rating').removeClass('text-yellow-400').addClass('text-gray-300');
    $('#ratingTextInput').text('0 étoiles');
    
    loadExistingFeedback(examId);
    
    $('#feedbackModal').removeClass('hidden');
}

function closeFeedbackModal() {
    $('#feedbackModal').addClass('hidden');
}

function loadExistingFeedback(examId) {
    $.ajax({
        url: `/candidats/exams/${examId}/feedback`,
        method: 'GET',
        success: function(response) {
            if(response.exists && response.feedback) {
                const feedback = response.feedback;
                
                $('#existingFeedbackContainer').removeClass('hidden');
                $('#existingExamFeedback').text(feedback.exam_feedback || 'Non fourni');
                $('#existingSchoolComment').text(feedback.school_comment || 'Non fourni');
                
                const rating = feedback.school_rating || 0;
                $('#existingSchoolRating').html(generateStarsHTML(rating));
                
                $('#examFeedbackInput').val(feedback.exam_feedback || '');
                $('#schoolCommentInput').val(feedback.school_comment || '');
                $('#schoolRatingInput').val(rating);
                highlightFeedbackStars(rating);
                $('#ratingTextInput').text(rating + (rating > 1 ? ' étoiles' : ' étoile'));
            } else {
                $('#existingFeedbackContainer').addClass('hidden');
            }
        },
        error: function(xhr) {
            console.error('Erreur lors du chargement du feedback', xhr.responseText);
        }
    });
}

function deleteFeedback() {
    const examId = $('#feedbackExamId').val();
    
    if(confirm('Êtes-vous sûr de vouloir supprimer votre feedback ?')) {
        $.ajax({
            url: `/candidats/exams/${examId}/feedback`,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.success) {
                    $('#existingFeedbackContainer').addClass('hidden');
                    
                    $('#examFeedbackInput').val('');
                    $('#schoolCommentInput').val('');
                    $('#schoolRatingInput').val('0');
                    $('.star-rating').removeClass('text-yellow-400').addClass('text-gray-300');
                    $('#ratingTextInput').text('0 étoiles');
                    
                    showAlert('success', 'Feedback supprimé avec succès!');
                }
            },
            error: function(xhr) {
                showAlert('error', 'Une erreur est survenue lors de la suppression du feedback.');
                console.error(xhr.responseText);
            }
        });
    }
}

// Fonctions utilitaires
function highlightFeedbackStars(rating) {
    $('.star-rating').each(function() {
        if ($(this).data('rating') <= rating) {
            $(this).removeClass('text-gray-300').addClass('text-yellow-400');
        } else {
            $(this).removeClass('text-yellow-400').addClass('text-gray-300');
        }
    });
}

function generateStarsHTML(rating) {
    let html = '';
    for (let i = 1; i <= 5; i++) {
        if (i <= rating) {
            html += `<svg class="w-5 h-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>`;
        } else {
            html += `<svg class="w-5 h-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>`;
        }
    }
    return html;
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

function showAlert(type, message) {
    const alertHtml = `
        <div class="fixed top-4 right-4 z-50">
            <div class="px-6 py-4 rounded-md shadow-lg ${type === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${type === 'success' ? 'M5 13l4 4L19 7' : 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'}"></path>
                    </svg>
                    <span>${message}</span>
                </div>
            </div>
        </div>
    `;
    
    $('body').append(alertHtml);
    setTimeout(() => {
        $('.fixed.top-4.right-4').fadeOut(500, function() {
            $(this).remove();
        });
    }, 3000);
}
</script>
@endsection