@extends('layouts.admin')
@section('content')

<div class="flex-1 overflow-auto p-4 md:p-6">

    <header class="bg-[#4D44B5] text-white shadow-md rounded-lg mb-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-xl md:text-2xl font-bold">Questions pour: {{ $quiz->title }}</h1>
            </div>
            <div class="flex flex-col sm:flex-row gap-2 w-full md:w-auto flex-shrink-0">
                <a href="{{ route('admin.quizzes') }}"
                    class="bg-white text-[#4D44B5] px-3 py-1.5 md:px-4 md:py-2 rounded-lg font-medium hover:bg-gray-100 transition text-center text-sm md:text-base flex items-center justify-center">
                    <i class="fas fa-arrow-left mr-2"></i>Retour aux Quiz
                </a>
                <button onclick="openQuestionModal('{{ $quiz->id }}')"
                    class="bg-white text-[#4D44B5] px-3 py-1.5 md:px-4 md:py-2 rounded-lg font-medium hover:bg-gray-100 transition text-sm md:text-base flex items-center justify-center">
                    <i class="fas fa-plus mr-2"></i>Nouvelle Question
                </button>
            </div>
        </div>
    </header>

    @if (session('success'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-4">
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-sm" role="alert">
            <div class="flex justify-between items-center">
                <p class="text-sm md:text-base">{{ session('success') }}</p>
                <button type="button" class="text-green-700 hover:text-green-900 text-lg" onclick="this.closest('[role=alert]').remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
    @endif

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow overflow-hidden border border-gray-100">
            @if ($questions->isEmpty())
            <div class="text-center p-6 md:p-12">
                <div class="mx-auto w-16 h-16 md:w-24 md:h-24 bg-gray-100 rounded-full flex items-center justify-center mb-3 md:mb-4">
                    <i class="fas fa-question text-gray-400 text-xl md:text-3xl"></i>
                </div>
                <h3 class="text-base md:text-lg font-medium text-gray-900 mb-1 md:mb-2">Aucune question disponible</h3>
                <p class="text-gray-500 text-sm md:text-base mb-4 md:mb-6">Commencez par créer votre première question pour ce quiz.</p>
                <button onclick="openQuestionModal('{{ $quiz->id }}')"
                    class="bg-[#4D44B5] text-white px-4 py-1.5 md:px-6 md:py-2 rounded-lg font-medium hover:bg-[#3a32a1] transition text-sm md:text-base flex items-center justify-center mx-auto">
                    <i class="fas fa-plus mr-2"></i>Créer une question
                </button>
            </div>
            @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 p-4 md:p-6">
                @foreach ($questions as $question)
                <div class="question-card bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden flex flex-col h-full">
                    <div class="p-4 md:p-5 flex-grow">
                        <div class="flex justify-between items-start mb-2 md:mb-3">
                            <h3 class="text-base md:text-lg font-semibold text-[#4D44B5] line-clamp-2 flex-1 mr-2" title="{{ $question->question_text }}">
                                {{ $loop->iteration }}. {{ Str::limit($question->question_text, 60) }}
                            </h3>
                            <button type="button" onclick="deleteQuestion('{{ $question->id }}')"
                                class="text-gray-400 hover:text-red-600 text-sm flex-shrink-0 p-1">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>

                        @if ($question->image_path)
                        <div class="mb-3 md:mb-4 rounded-lg overflow-hidden h-32 md:h-40 flex items-center justify-center bg-gray-50 border border-gray-100">
                            <img src="{{ asset('storage/' . $question->image_path) }}"
                                class="max-h-full max-w-full object-contain cursor-pointer"
                                alt="Image de question"
                                onclick="showQuestionDetails('{{ $question->id }}')">
                        </div>
                        @else
                         <div class="mb-3 md:mb-4 rounded-lg h-32 md:h-40 flex items-center justify-center bg-gray-50 border border-gray-100 text-gray-400 text-sm">
                            Aucune image
                        </div>
                        @endif

                        <div class="flex items-center justify-between text-xs md:text-sm text-gray-600">
                            <span class="bg-gray-100 text-gray-800 px-2 py-0.5 rounded-full flex items-center">
                                <i class="fas fa-stopwatch mr-1"></i> {{ $question->duration }}s
                            </span>
                            <span>
                                {{ count($question->choices) }} {{ Str::plural('choix', count($question->choices)) }}
                            </span>
                        </div>
                    </div>
                    <div class="bg-gray-50 border-t border-gray-100 px-4 py-2 md:px-5 md:py-3">
                        <button onclick="showQuestionDetails('{{ $question->id }}')"
                            class="w-full bg-[#4D44B5] bg-opacity-10 text-[#4D44B5] hover:bg-opacity-20 px-3 py-1.5 rounded-lg text-xs md:text-sm font-medium transition flex items-center justify-center">
                            <i class="fas fa-eye mr-1.5"></i> Voir détails
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </main>

    <div id="questionDetailsModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-60 flex justify-center items-center z-50 p-4">
        <div class="bg-white w-full max-w-md md:max-w-2xl rounded-lg shadow-xl max-h-[90vh] flex flex-col">
            <div class="bg-[#4D44B5] text-white px-4 py-3 md:px-6 md:py-4 flex justify-between items-center flex-shrink-0">
                <h2 class="text-lg md:text-xl font-bold">Détails de la question</h2>
                <button onclick="closeModal('questionDetailsModal')" class="text-white hover:text-gray-200 text-xl p-1">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-4 md:p-6 overflow-y-auto" id="questionDetailsContent">
                <div class="flex justify-center items-center py-8">
                    <div class="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-[#4D44B5]"></div>
                    <span class="ml-3 text-gray-600">Chargement...</span>
                </div>
            </div>
        </div>
    </div>

    <div id="questionModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-60 flex justify-center items-center z-[60] p-4">
        <div class="bg-white w-full max-w-md md:max-w-2xl rounded-lg shadow-xl max-h-[90vh] flex flex-col">
            <div class="bg-[#4D44B5] text-white px-4 py-3 md:px-6 md:py-4 flex justify-between items-center flex-shrink-0">
                <h2 class="text-lg md:text-xl font-bold" id="modalQuestionTitle">Nouvelle Question</h2>
                 <button type="button" id="closeQuestionModalBtn" class="text-white hover:text-gray-200 text-xl p-1">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="questionForm" method="POST" enctype="multipart/form-data" class="p-4 md:p-6 overflow-y-auto flex-grow">
                @csrf
                <input type="hidden" id="quizId" name="quiz_id">
                <input type="hidden" id="questionId" name="question_id">
                <input type="hidden" id="removeImageFlag" name="remove_image" value="0">

                <div id="formErrorsQuestion" class="hidden mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Erreur !</strong>
                    <span class="block sm:inline">Veuillez corriger les erreurs suivantes :</span>
                    <ul class="mt-2 list-disc list-inside text-sm"></ul>
                </div>

                <div class="space-y-4 md:space-y-5">
                    <div>
                        <label for="questionText" class="block text-sm md:text-base font-medium text-gray-700 mb-1">Texte de la question *</label>
                        <textarea id="questionText" name="question_text" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-offset-1 focus:ring-[#4D44B5] focus:border-[#4D44B5] transition text-sm md:text-base"></textarea>
                        <p class="mt-1 text-xs text-red-600 hidden" id="questionTextError">Le texte de la question est requis.</p>
                    </div>

                    <div>
                        <label class="block text-sm md:text-base font-medium text-gray-700 mb-1.5">Image (Optionnel)</label>
                        <div class="flex flex-col sm:flex-row items-center gap-3">
                            <div class="w-full sm:flex-1">
                                <input type="file" id="questionImage" name="image" accept="image/png, image/jpeg, image/jpg, image/gif"
                                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-l-lg file:border-0 file:text-sm file:font-semibold file:bg-[#e0dff2] file:text-[#4D44B5] hover:file:bg-[#c8c5e8]">
                                <p class="mt-1 text-xs text-gray-500">Formats: PNG, JPG, GIF.</p>
                            </div>
                            <div id="imagePreviewContainer" class="hidden flex-shrink-0">
                                <div class="relative w-20 h-20 md:w-24 md:h-24 rounded-lg overflow-hidden border border-gray-200 group bg-gray-50">
                                    <img id="imagePreview" class="w-full h-full object-cover">
                                    <button type="button" onclick="removeImage()"
                                        class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity text-xs" title="Supprimer l'image">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="questionDuration" class="block text-sm md:text-base font-medium text-gray-700 mb-1">Durée (secondes) *</label>
                        <input type="number" id="questionDuration" name="duration" min="5" max="30" value="30"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-offset-1 focus:ring-[#4D44B5] focus:border-[#4D44B5] transition text-sm md:text-base">
                        <p class="mt-1 text-xs text-red-600 hidden" id="questionDurationError">La durée doit être entre 5 et 30 secondes.</p>
                    </div>

                    <div class="pt-4 border-t border-gray-200">
                        <div class="flex justify-between items-center mb-3">
                            <h3 class="text-sm md:text-base font-medium text-gray-700">Choix de réponse * <span class="text-xs text-gray-500">(min 2, max 5)</span></h3>
                            <button type="button" id="addChoiceBtn"
                                class="text-[#4D44B5] hover:text-[#3a32a1] text-xs md:text-sm font-medium flex items-center">
                                <i class="fas fa-plus-circle mr-1"></i>Ajouter un choix
                            </button>
                        </div>
                        <div id="choicesContainer" class="space-y-3">
                        </div>
                        <p class="mt-1 text-xs text-red-600 hidden" id="choicesError">Au moins 2 choix sont requis, et un doit être marqué comme correct.</p>
                        <p class="mt-1 text-xs text-red-600 hidden" id="choiceTextError">Le texte de chaque choix est requis.</p>
                    </div>
                </div>
            </form>
            <div class="p-4 md:p-6 border-t border-gray-200 bg-gray-50 flex justify-end space-x-3 flex-shrink-0">
                <button type="button" id="cancelQuestionBtn"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium text-sm md:text-base">
                    Annuler
                </button>
                <button type="submit" form="questionForm"
                    class="px-4 py-2 bg-[#4D44B5] text-white rounded-lg hover:bg-[#3a32a1] transition font-medium text-sm md:text-base">
                    Enregistrer
                </button>
            </div>
        </div>
    </div>

    <div id="toast-container" class="fixed top-5 right-5 z-[100] space-y-2"></div>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function toggleModal(modalId, show = true) {
        const modal = document.getElementById(modalId);
        if (!modal) return;
        if (show) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.classList.add('overflow-hidden');
        } else {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
        }
    }

    function closeModal(modalId) {
        toggleModal(modalId, false);
    }

    function showQuestionDetails(questionId) {
        const modalContent = $('#questionDetailsContent');
        modalContent.html(`
            <div class="flex justify-center items-center py-8">
                <div class="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-[#4D44B5]"></div>
                <span class="ml-3 text-gray-600">Chargement...</span>
            </div>
        `);
        toggleModal('questionDetailsModal');

        $.ajax({
            url: `/admin/questions/${questionId}/details`,
            method: 'GET',
            success: function(response) {
                const question = response.question;
                const detailsHtml = `
                    <div>
                        <h3 class="text-lg md:text-xl font-semibold text-gray-800 mb-3 break-words">${question.question_text || 'Sans texte'}</h3>
                        
                        ${question.image_url ? `
                            <div class="mb-4 flex justify-center bg-gray-50 p-2 rounded-lg border border-gray-200">
                                <img src="${question.image_url}" 
                                     onerror="this.onerror=null;this.parentElement.innerHTML='<div class=\'text-red-500 text-sm p-4\'>Image non disponible</div>';"
                                     class="rounded-md max-w-full h-auto max-h-60 object-contain" 
                                     alt="Image de question">
                            </div>
                        ` : `<p class="text-gray-400 text-sm mb-4 italic">Aucune image associée</p>`}
                        
                        <div class="mb-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
                            <span class="bg-gray-100 text-gray-800 text-xs px-2.5 py-1 rounded-full flex items-center">
                                <i class="fas fa-stopwatch mr-1.5"></i> ${question.duration || 0} secondes
                            </span>
                            <div class="flex space-x-3">
                                <button onclick="openEditModal('${question.id}')" 
                                        class="text-[#4D44B5] hover:text-[#3a32a1] text-sm flex items-center">
                                    <i class="fas fa-edit mr-1"></i> Modifier
                                </button>
                                <button onclick="deleteQuestion('${question.id}')" 
                                        class="text-red-500 hover:text-red-700 text-sm flex items-center">
                                    <i class="fas fa-trash mr-1"></i> Supprimer
                                </button>
                            </div>
                        </div>
                        
                        <h4 class="font-medium text-gray-700 mb-2 text-base">Choix de réponses:</h4>
                        <div class="space-y-2">
                            ${question.choices.map((choice, index) => `
                                <div class="flex items-start p-3 rounded-lg ${choice.is_correct ? 'bg-green-50 border border-green-200' : 'bg-gray-50 border border-gray-100'}">
                                    <span class="font-medium mr-3 text-gray-600">${String.fromCharCode(65 + index)}.</span>
                                    <span class="flex-1 break-words ${choice.is_correct ? 'font-semibold text-green-700' : 'text-gray-700'}">
                                        ${choice.choice_text || 'Choix sans texte'}
                                    </span>
                                    ${choice.is_correct ? `
                                        <span class="ml-3 flex-shrink-0 bg-green-100 text-green-800 text-xs px-2 py-0.5 rounded-full font-medium">
                                            Correct
                                        </span>
                                    ` : ''}
                                </div>
                            `).join('')}
                        </div>
                    </div>
                `;
                modalContent.html(detailsHtml);
            },
            error: function(xhr) {
                let errorMsg = 'Erreur lors du chargement des détails';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                modalContent.html(`
                    <div class="text-center py-8 text-red-500">
                        <i class="fas fa-exclamation-circle text-2xl mb-2"></i>
                        <p>${errorMsg}</p>
                        <button onclick="retryLoadDetails('${questionId}')" 
                                class="mt-3 px-4 py-1.5 bg-[#4D44B5] text-white rounded hover:bg-[#3a32a1] text-sm font-medium">
                            <i class="fas fa-redo mr-1"></i> Réessayer
                        </button>
                    </div>
                `);
            }
        });
    }

    function retryLoadDetails(questionId) {
        showQuestionDetails(questionId);
    }

    function openEditModal(questionId) {
        closeModal('questionDetailsModal');
        openQuestionModal($('#quizId').val(), questionId);
    }

    function resetQuestionFormValidation() {
        $('#formErrorsQuestion').addClass('hidden').find('ul').empty();
        $('#questionText').removeClass('border-red-500 focus:border-red-500 focus:ring-red-500').addClass('border-gray-300 focus:border-[#4D44B5] focus:ring-[#4D44B5]');
        $('#questionTextError').addClass('hidden');
        $('#questionDuration').removeClass('border-red-500 focus:border-red-500 focus:ring-red-500').addClass('border-gray-300 focus:border-[#4D44B5] focus:ring-[#4D44B5]');
        $('#questionDurationError').addClass('hidden');
        $('#choicesError').addClass('hidden');
        $('#choiceTextError').addClass('hidden');
        $('#choicesContainer').find('input[type="text"]').removeClass('border-red-500 focus:border-red-500 focus:ring-red-500').addClass('border-gray-300 focus:border-[#4D44B5] focus:ring-[#4D44B5]');
    }

    function validateQuestionForm() {
        let isValid = true;
        const errors = [];
        resetQuestionFormValidation();

        const questionText = $('#questionText').val().trim();
        if (!questionText) {
            isValid = false;
            $('#questionText').addClass('border-red-500 focus:border-red-500 focus:ring-red-500').removeClass('border-gray-300 focus:border-[#4D44B5] focus:ring-[#4D44B5]');
            $('#questionTextError').removeClass('hidden');
            errors.push('Le texte de la question est requis.');
        }

        const duration = parseInt($('#questionDuration').val());
        if (isNaN(duration) || duration < 5 || duration > 30) { // Changed max value from 300 to 30
            isValid = false;
            $('#questionDuration').addClass('border-red-500 focus:border-red-500 focus:ring-red-500').removeClass('border-gray-300 focus:border-[#4D44B5] focus:ring-[#4D44B5]');
            $('#questionDurationError').removeClass('hidden').text('La durée doit être un nombre entre 5 et 30.'); // Updated error message
            errors.push('La durée doit être un nombre entre 5 et 30.');
        }

        const choices = $('#choicesContainer .choice-item');
        let correctChoiceSelected = false;
        let allChoiceTextsFilled = true;

        if (choices.length < 2 || choices.length > 5) {
            isValid = false;
            $('#choicesError').removeClass('hidden').text(`Au moins 2 et au maximum 5 choix sont requis (actuellement ${choices.length}).`);
            errors.push('Le nombre de choix doit être entre 2 et 5.');
        } else {
            choices.each(function() {
                const choiceText = $(this).find('input[type="text"]').val().trim();
                if (!choiceText) {
                    allChoiceTextsFilled = false;
                    $(this).find('input[type="text"]').addClass('border-red-500 focus:border-red-500 focus:ring-red-500').removeClass('border-gray-300 focus:border-[#4D44B5] focus:ring-[#4D44B5]');
                }
                if ($(this).find('input[type="radio"]').is(':checked')) {
                    correctChoiceSelected = true;
                }
            });

            if (!allChoiceTextsFilled) {
                isValid = false;
                $('#choiceTextError').removeClass('hidden');
                errors.push('Le texte de chaque choix est requis.');
            }

            if (!correctChoiceSelected) {
                isValid = false;
                $('#choicesError').removeClass('hidden').text('Veuillez marquer une réponse comme correcte.');
                errors.push('Une réponse correcte doit être sélectionnée.');
            }
        }

        if (!isValid) {
            const errorList = $('#formErrorsQuestion').find('ul');
            errors.forEach(error => {
                errorList.append(`<li>${error}</li>`);
            });
            $('#formErrorsQuestion').removeClass('hidden');
            $('#questionModal .overflow-y-auto').scrollTop(0);
        }

        return isValid;
    }

    function openQuestionModal(quizId, questionId = null) {
        const $form = $('#questionForm');
        $form[0].reset();
        resetQuestionFormValidation();
        $('#imagePreviewContainer').addClass('hidden');
        $('#choicesContainer').empty();
        $('#quizId').val(quizId);
        $('#removeImageFlag').val('0');

        if (questionId) {
            $('#modalQuestionTitle').text('Modifier la question');
            $form.attr('action', `/admin/questions/${questionId}`);
            $form.find('input[name="_method"]').remove();
            $form.append('<input type="hidden" name="_method" value="PUT">');
            $('#questionId').val(questionId);

            $.ajax({
                url: `/admin/questions/${questionId}/edit`,
                method: 'GET',
                success: function(data) {
                    $('#questionText').val(data.question.question_text);
                    $('#questionDuration').val(data.question.duration);

                    if (data.question.image_path) {
                        $('#imagePreview').attr('src', `/storage/${data.question.image_path}`);
                        $('#imagePreviewContainer').removeClass('hidden');
                    }

                    data.choices.forEach((choice, index) => {
                        addChoiceToForm(choice.choice_text, choice.is_correct, choice.id, index);
                    });
                    toggleModal('questionModal');
                },
                error: function() {
                    showToast('Erreur lors du chargement de la question', false);
                }
            });
        } else {
            $('#modalQuestionTitle').text('Nouvelle Question');
            $form.attr('action', `/admin/${quizId}/questions`);
            $form.find('input[name="_method"]').remove();
            $('#questionId').val('');
            addChoiceToForm('', true); 
            addChoiceToForm('', false);
            toggleModal('questionModal');
        }
    }

    function addChoiceToForm(text = '', isCorrect = false, choiceId = null, index = null) {
        const $container = $('#choicesContainer');
        const newIndex = index !== null ? index : $container.children().length;

        if ($container.children().length >= 5) {
            showToast('Maximum 5 choix autorisés', false);
            return;
        }

        const choiceHtml = `
            <div class="choice-item p-2 md:p-3 border border-gray-200 rounded-lg bg-gray-50">
                <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-3">
                    <div class="flex items-center gap-2 md:gap-3 flex-grow">
                        <input type="radio" name="correct_choice" value="${newIndex}" 
                               id="correct_choice_${newIndex}"
                               class="h-4 w-4 text-[#4D44B5] border-gray-300 focus:ring-[#4D44B5] flex-shrink-0"
                               ${isCorrect ? 'checked' : ''}>
                        <label for="correct_choice_${newIndex}" class="sr-only">Marquer comme correct</label>
                        <input type="text" name="choices[${newIndex}][text]" 
                               class="flex-1 px-2 py-1 md:px-3 md:py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-offset-1 focus:ring-[#4D44B5] focus:border-[#4D44B5] transition text-sm md:text-base"
                               placeholder="Texte du choix ${newIndex + 1}" 
                               value="${text}">
                    </div>
                    <div class="flex justify-end md:block flex-shrink-0">
                        <button type="button" class="remove-choice-btn text-gray-400 hover:text-red-500 p-1 rounded-full text-sm flex items-center"
                                ${$container.children().length < 2 ? 'disabled' : ''}>
                            <i class="fas fa-times mr-1"></i> Supprimer
                        </button>
                    </div>
                    <input type="hidden" name="choices[${newIndex}][id]" value="${choiceId || ''}">
                </div>
            </div>
        `;

        $container.append(choiceHtml);
        updateRemoveButtons();
    }

    function updateRemoveButtons() {
        const $container = $('#choicesContainer');
        const canRemove = $container.children().length > 2;
        $container.find('.remove-choice-btn').each(function() {
            $(this).prop('disabled', !canRemove);
            $(this).toggleClass('cursor-not-allowed opacity-50', !canRemove);
        });
    }

    function deleteQuestion(questionId) {
        if (!confirm('Êtes-vous sûr de vouloir supprimer cette question? Cette action est irréversible.')) return;

        $.ajax({
            url: `/admin/questions/${questionId}`,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || $("input[name='_token']").val()
            },
            success: function(response) {
                showToast(response.message || 'Question supprimée avec succès.', true);
                $(`.question-card button[onclick*="deleteQuestion('${questionId}')"]`).closest('.question-card').fadeOut(300, function() { $(this).remove(); });
                if ($('.question-card').length === 0) {
                    setTimeout(() => window.location.reload(), 1000);
                }
            },
            error: function(xhr) {
                showToast(xhr.responseJSON?.message || 'Erreur lors de la suppression.', false);
            }
        });
    }

    function removeImage() {
        $('#imagePreviewContainer').addClass('hidden');
        $('#questionImage').val('');
        $('#imagePreview').attr('src', '');
        $('#removeImageFlag').val('1');
    }

    function showToast(message, isSuccess = true) {
        const toastId = `toast-${Date.now()}`;
        const toastBg = isSuccess ? 'bg-green-500' : 'bg-red-600';
        const icon = isSuccess ? 'fa-check-circle' : 'fa-exclamation-triangle';

        const toastHtml = `
            <div id="${toastId}" class="${toastBg} text-white px-4 py-3 md:px-6 md:py-4 rounded-lg shadow-lg flex items-center text-sm md:text-base opacity-0 transform translate-x-full transition-all duration-300 ease-out">
                <i class="fas ${icon} mr-2"></i>
                <span>${message}</span>
            </div>
        `;

        $('#toast-container').append(toastHtml);
        
        setTimeout(() => {
            $(`#${toastId}`).removeClass('opacity-0 translate-x-full').addClass('opacity-100 translate-x-0');
        }, 10);

        setTimeout(() => {
            $(`#${toastId}`).removeClass('opacity-100 translate-x-0').addClass('opacity-0 translate-x-full');
            setTimeout(() => {
                $(`#${toastId}`).remove();
            }, 300);
        }, 3500);
    }

    $(document).ready(function() {
        $('#questionImage').change(function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreviewContainer').removeClass('hidden');
                    $('#imagePreview').attr('src', e.target.result);
                    $('#removeImageFlag').val('0');
                };
                reader.readAsDataURL(this.files[0]);
            } else {
                removeImage();
            }
        });

        $('#addChoiceBtn').click(function() {
            addChoiceToForm();
        });

        $('#choicesContainer').on('click', '.remove-choice-btn', function() {
            if ($(this).prop('disabled')) return;

            const $container = $('#choicesContainer');
            const $choiceItem = $(this).closest('.choice-item');
            const wasChecked = $choiceItem.find('input[type="radio"]').prop('checked');
            
            $choiceItem.remove();
            
            if (wasChecked && $container.children().length > 0) {
                $container.find('input[type="radio"]').first().prop('checked', true);
            }
            updateRemoveButtons();
        });

        $('#cancelQuestionBtn, #closeQuestionModalBtn').click(function() {
            closeModal('questionModal');
        });

        $('#questionForm').submit(function(e) {
            e.preventDefault();

            if (!validateQuestionForm()) {
                return;
            }

            const $form = $(this);
            const formData = new FormData(this);
            const $submitBtn = $form.closest('.bg-white').find('button[type="submit"]');
            const originalBtnText = $submitBtn.html();

            $submitBtn.prop('disabled', true);
            $submitBtn.html('<i class="fas fa-spinner fa-spin mr-2"></i> Enregistrement...');

            $.ajax({
                url: $form.attr('action'),
                method: $form.find('input[name="_method"]').val() || 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || $("input[name='_token']").val()
                },
                success: function(response) {
                    closeModal('questionModal');
                    showToast(response.message || 'Question enregistrée avec succès.', true);
                    setTimeout(() => window.location.reload(), 1500);
                },
                error: function(xhr) {
                    let errorMsg = 'Erreur lors de l\'enregistrement.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        const errors = Object.values(xhr.responseJSON.errors).flat();
                        const errorList = $('#formErrorsQuestion').find('ul');
                        errorList.empty();
                        errors.forEach(error => errorList.append(`<li>${error}</li>`));
                        $('#formErrorsQuestion').removeClass('hidden');
                        $('#questionModal .overflow-y-auto').scrollTop(0);
                    } else {
                         showToast(errorMsg, false);
                    }
                },
                complete: function() {
                    $submitBtn.prop('disabled', false);
                    $submitBtn.html(originalBtnText);
                }
            });
        });

        $(document).on('click', function(event) {
            if ($(event.target).is('#questionModal') || $(event.target).is('#questionDetailsModal')) {
                closeModal($(event.target).attr('id'));
            }
        });

        const initialCards = document.querySelectorAll('.question-card');
        initialCards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.4s ease-out, transform 0.4s ease-out';
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 80);
        });
    });
</script>
@endsection