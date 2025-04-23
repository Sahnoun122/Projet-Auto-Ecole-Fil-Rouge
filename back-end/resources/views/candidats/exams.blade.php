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

    <div id="planningModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50 p-4">
    </div>

    <div id="resultsModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50 p-4">
    </div>

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
    $('#closePlanningBtn, #closePlanningBtnBottom').click(function() {
        $('#planningModal').addClass('hidden');
    });
    
    $('#closeResultsBtn, #closeResultsBtnBottom').click(function() {
        $('#resultsModal').addClass('hidden');
    });
    
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
    
    $('#feedbackForm').submit(function(e) {
        e.preventDefault();
        
      
        </script>
@endsection