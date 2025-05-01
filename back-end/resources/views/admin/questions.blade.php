@extends('layouts.admin')
@section('content')
<div class="flex-1 overflow-auto p-4 md:p-6">
   
    <div class="bg-[#4D44B5] text-white shadow-md rounded-lg mb-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                <div class="mb-3 md:mb-0">
                    <h1 class="text-xl md:text-2xl font-bold">Questions pour: {{ $quiz->title }}</h1>
                </div>
                <div class="flex flex-row gap-2 w-full md:w-auto self-start">
                    <a href="{{ route('admin.quizzes') }}" class="bg-white text-[#4D44B5] px-4 py-2 rounded-lg font-semibold hover:bg-gray-100 hover:shadow-sm transition-all duration-200 flex items-center justify-center">
                        <i class="fas fa-arrow-left mr-2"></i>Retour
                    </a>
                    <button onclick="openQuestionModal('{{ $quiz->id }}')" class="bg-white text-[#4D44B5] px-4 py-2 rounded-lg font-semibold hover:bg-gray-100 hover:shadow-sm transition-all duration-200 flex items-center justify-center">
                        <i class="fas fa-plus mr-2"></i>Question
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

    @if (session('success'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2">
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
            <div class="flex justify-between items-center">
                <p class="text-sm md:text-base">{{ session('success') }}</p>
                <button type="button" class="text-green-700" onclick="this.parentElement.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
    @endif

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8">
        <div class="bg-white rounded-xl shadow overflow-hidden">
            @if ($questions->isEmpty())
            <div class="text-center p-6 md:p-12">
                <div class="mx-auto w-16 h-16 md:w-24 md:h-24 bg-gray-100 rounded-full flex items-center justify-center mb-3 md:mb-4">
                    <i class="fas fa-question text-gray-400 text-xl md:text-3xl"></i>
                </div>
                <h3 class="text-base md:text-lg font-medium text-gray-900 mb-1 md:mb-2">Aucune question disponible</h3>
                <p class="text-gray-500 text-sm md:text-base mb-4 md:mb-6">Commencez par créer votre première question pour ce quiz.</p>
                <button onclick="openQuestionModal('{{ $quiz->id }}')" class="bg-[#4D44B5] text-white px-4 py-1 md:px-6 md:py-2 rounded-lg font-medium hover:bg-[#3a32a1] transition text-sm md:text-base">
                    <i class="fas fa-plus mr-2"></i>Créer une question
                </button>
            </div>
            @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 p-4 md:p-6">
                @foreach ($questions as $question)
                <div class="question-card bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden flex flex-col">
                    <div class="p-3 md:p-5 flex flex-col flex-grow">
                        <div class="flex justify-between items-start mb-2 md:mb-3">
                            <h3 class="text-base md:text-lg font-semibold text-[#4D44B5] line-clamp-2 flex-grow mr-2" title="{{ $question->question_text }}">
                                {{ $loop->iteration }}. {{ Str::limit($question->question_text, 50) }}
                            </h3>
                            <button type="button" onclick="deleteQuestion('{{ $question->id }}')" class="text-red-500 hover:text-red-700 text-sm flex-shrink-0">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>

                        @if ($question->image_path)
                        <div class="mb-2 md:mb-3 rounded-lg overflow-hidden h-32 md:h-40 flex items-center justify-center bg-gray-100 cursor-pointer" onclick="showQuestionDetails('{{ $question->id }}')">
                            <img src="{{ asset('storage/' . $question->image_path) }}" class="max-h-full max-w-full object-contain" alt="Image de question">
                        </div>
                        @else
                         <div class="mb-2 md:mb-3 rounded-lg h-32 md:h-40 flex items-center justify-center bg-gray-100 text-gray-400 text-sm italic">
                            Pas d'image
                        </div>
                        @endif

                        <div class="flex items-center justify-between mb-2 md:mb-3 mt-auto">
                            <span class="bg-gray-100 text-gray-800 text-xs px-2 py-0.5 rounded-full flex items-center">
                                <i class="fas fa-clock mr-1"></i> {{ $question->duration }}s
                            </span>
                            <span class="text-xs text-gray-500">
                                {{ count($question->choices) }} choix
                            </span>
                        </div>

                        <button onclick="showQuestionDetails('{{ $question->id }}')" class="w-full mt-1 md:mt-2 bg-[#4D44B5] bg-opacity-10 text-[#4D44B5] hover:bg-opacity-20 px-2 py-1 md:px-3 md:py-1 rounded-lg text-xs md:text-sm font-medium transition">
                            Voir détails
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </main>

    <div id="questionDetailsModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50 p-2 md:p-4">
        <div class="bg-white w-full max-w-md md:max-w-2xl rounded-lg overflow-hidden max-h-[90vh] overflow-y-auto modal-content">
            <div class="bg-[#4D44B5] text-white px-4 py-3 md:px-6 md:py-4 flex justify-between items-center">
                <h2 class="text-lg md:text-xl font-bold">Détails de la question</h2>
                <button onclick="closeModal('questionDetailsModal')" class="text-white hover:text-gray-200 text-lg">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-4 md:p-6" id="questionDetailsContent">
                <div class="flex justify-center items-center py-4">
                    <div class="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-[#4D44B5]"></div>
                    <span class="ml-3">Chargement...</span>
                </div>
            </div>
        </div>
    </div>

    <div id="questionModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50 p-2 md:p-4">
        <div class="bg-white w-full max-w-md md:max-w-2xl rounded-lg overflow-hidden max-h-[90vh] overflow-y-auto modal-content">
            <div class="bg-[#4D44B5] text-white px-4 py-3 md:px-6 md:py-4">
                <h2 class="text-lg md:text-xl font-bold" id="modalQuestionTitle">Nouvelle Question</h2>
            </div>
            <form id="questionForm" method="POST" enctype="multipart/form-data" class="p-4 md:p-6">
                @csrf
                <input type="hidden" id="quizId" name="quiz_id">
                <input type="hidden" id="questionId" name="question_id">

                <div class="space-y-4 md:space-y-6">
                    <div>
                        <label for="questionText" class="block text-sm md:text-base font-medium text-gray-700 mb-1">Texte de la question *</label>
                        <textarea id="questionText" name="question_text" rows="3" class="w-full px-3 py-2 md:px-4 md:py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-[#4D44B5] transition text-sm md:text-base" required></textarea>
                    </div>

                    <div>
                        <label class="block text-sm md:text-base font-medium text-gray-700 mb-1 md:mb-2">Image</label>
                        <div class="flex flex-col md:flex-row items-center space-y-3 md:space-y-0 md:space-x-4">
                            <div class="relative w-full">
                                <input type="file" id="questionImage" name="image" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                            </div>
                            <div id="imagePreviewContainer" class="hidden flex-shrink-0">
                                <div class="relative w-20 h-20 md:w-24 md:h-24 rounded-lg overflow-hidden border border-gray-200">
                                    <img id="imagePreview" class="w-full h-full object-cover">
                                    <button type="button" onclick="removeImage()" class="absolute top-0.5 right-0.5 md:top-1 md:right-1 bg-red-500 text-white rounded-full w-4 h-4 md:w-5 md:h-5 flex items-center justify-center text-xs">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="removeImageFlag" name="remove_image" value="0">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                        <div>
                            <label for="questionDuration" class="block text-sm md:text-base font-medium text-gray-700 mb-1">Durée (secondes) *</label>
                            <input type="number" id="questionDuration" name="duration" min="5" max="60" value="30" class="w-full px-3 py-2 md:px-4 md:py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-[#4D44B5] transition text-sm md:text-base" required>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-gray-200">
                        <div class="flex justify-between items-center mb-3">
                            <h3 class="text-sm md:text-base font-medium text-gray-700">Choix de réponse *</h3>
                            <button type="button" id="addChoiceBtn" class="text-[#4D44B5] hover:text-[#3a32a1] text-xs md:text-sm font-medium flex items-center">
                                <i class="fas fa-plus-circle mr-1"></i>Ajouter un choix
                            </button>
                        </div>
                        <div id="choicesContainer" class="space-y-2 md:space-y-3">
                        </div>
                    </div>
                </div>

                <div class="mt-6 md:mt-8 flex justify-end space-x-2 md:space-x-3">
                    <button type="button" id="cancelQuestionBtn" class="px-4 py-1 md:px-6 md:py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition font-medium text-sm md:text-base">
                        Annuler
                    </button>
                    <button type="submit" class="px-4 py-1 md:px-6 md:py-2 bg-[#4D44B5] text-white rounded-lg hover:bg-[#3a32a1] transition font-medium text-sm md:text-base">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="successToast" class="hidden fixed top-4 right-4 z-50">
        <div class="bg-green-500 text-white px-4 py-3 md:px-6 md:py-4 rounded-lg shadow-lg flex items-center text-sm md:text-base">
            <i class="fas fa-check-circle mr-2"></i>
            <span id="successMessage"></span>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function toggleModal(modalId, show = true) {
        const modal = document.getElementById(modalId);
        if (show) {
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        } else {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    }

    function closeModal(modalId) {
        toggleModal(modalId, false);
    }

    function showQuestionDetails(questionId) {
        const modalContent = $('#questionDetailsContent');
        modalContent.html(`
            <div class="flex justify-center items-center py-4">
                <div class="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-[#4D44B5]"></div>
                <span class="ml-3">Chargement...</span>
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
                        <h3 class="text-lg font-semibold text-[#4D44B5] mb-3">${question.question_text || 'Sans texte'}</h3>
                        ${question.image_url ? `
                            <div class="mb-4 flex justify-center">
                                <img src="${question.image_url}" 
                                     onerror="this.onerror=null;this.parentElement.innerHTML='<div class=\\'text-red-500 text-center p-4 bg-red-50 rounded border border-red-200\\'>Image non disponible</div>';"
                                     class="rounded-lg border border-gray-200 max-w-full h-auto max-h-60 object-contain" 
                                     alt="Image de question">
                            </div>
                        ` : `<p class="text-gray-400 mb-4 text-center italic">Aucune image</p>`}
                        <div class="mb-4 flex items-center justify-between flex-wrap gap-2">
                            <span class="bg-gray-100 text-gray-800 text-xs px-2.5 py-0.5 rounded-full flex items-center">
                                <i class="fas fa-clock mr-1"></i> ${question.duration || 0} secondes
                            </span>
                            <div class="flex space-x-3">
                                <button onclick="openEditModal('${question.id}')" class="text-[#4D44B5] hover:text-[#3a32a1] text-sm flex items-center">
                                    <i class="fas fa-edit mr-1"></i> Modifier
                                </button>
                                <button onclick="deleteQuestion('${question.id}')" class="text-red-500 hover:text-red-700 text-sm flex items-center">
                                    <i class="fas fa-trash mr-1"></i> Supprimer
                                </button>
                            </div>
                        </div>
                        <h4 class="font-medium text-gray-700 mb-2">Choix de réponses:</h4>
                        <div class="space-y-2">
                            ${question.choices.map((choice, index) => `
                                <div class="flex items-start p-3 rounded-lg ${choice.is_correct ? 'bg-green-50 border border-green-200' : 'bg-gray-50 border border-gray-100'}">
                                    <span class="font-medium mr-3 flex-shrink-0">${String.fromCharCode(65 + index)}.</span>
                                    <span class="flex-grow ${choice.is_correct ? 'font-medium text-green-700' : 'text-gray-800'}">
                                        ${choice.choice_text || 'Choix sans texte'}
                                    </span>
                                    ${choice.is_correct ? `
                                        <span class="ml-auto flex-shrink-0 bg-green-100 text-green-800 text-xs px-2 py-0.5 rounded-full">
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
                    <div class="text-center py-4 text-red-500">
                        <i class="fas fa-exclamation-circle text-xl mb-2"></i>
                        <p>${errorMsg}</p>
                        <button onclick="retryLoadDetails('${questionId}')" class="mt-2 px-3 py-1 bg-[#4D44B5] text-white rounded hover:bg-[#3a32a1] text-sm">
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

    function openQuestionModal(quizId, questionId = null) {
        const $form = $('#questionForm');
        $form[0].reset();
        $('#imagePreviewContainer').addClass('hidden');
        $('#choicesContainer').empty();
        $('#quizId').val(quizId);
        $('#removeImageFlag').val('0');
        $form.find('.error-message').remove();
        $form.find('.border-red-500').removeClass('border-red-500');

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
                    } else {
                         $('#imagePreviewContainer').addClass('hidden');
                         $('#imagePreview').attr('src', '');
                    }

                    data.choices.forEach((choice, index) => {
                        addChoiceToForm(choice.choice_text, choice.is_correct, choice.id, index);
                    });
                    if (data.choices.length === 0) {
                         addChoiceToForm('', true);
                         addChoiceToForm('', false);
                    }
                    updateRemoveButtons();
                },
                error: function() {
                    showToast('Erreur lors du chargement de la question', false);
                    closeModal('questionModal');
                }
            });
        } else {
            $('#modalQuestionTitle').text('Nouvelle Question');
            $form.attr('action', `/admin/${quizId}/questions`);
            $form.find('input[name="_method"]').remove();
            $('#questionId').val('');
            addChoiceToForm('', true);
            addChoiceToForm('', false);
            updateRemoveButtons();
        }

        toggleModal('questionModal');
    }

    function addChoiceToForm(text = '', isCorrect = false, choiceId = null, index = null) {
        const $container = $('#choicesContainer');
        const newIndex = index !== null ? index : $container.children().length;

        if ($container.children().length >= 5) {
            showToast('Maximum 5 choix par question', false);
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
                        <input type="text" name="choices[${newIndex}][text]" 
                               class="flex-grow px-2 py-1 md:px-3 md:py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-[#4D44B5] transition text-sm md:text-base" 
                               placeholder="Texte du choix ${newIndex + 1}" 
                               value="${text}" required>
                    </div>
                    <div class="flex justify-end md:block flex-shrink-0">
                        <button type="button" class="remove-choice-btn text-gray-400 hover:text-red-500 p-1 rounded-full text-xs md:text-sm flex items-center" title="Supprimer ce choix">
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
            $(this).toggleClass('opacity-50 cursor-not-allowed', !canRemove);
        });
    }

    function deleteQuestion(questionId) {
        if (!confirm('Êtes-vous sûr de vouloir supprimer cette question et ses choix associés? Cette action est irréversible.')) return;

        $.ajax({
            url: `/admin/questions/${questionId}`,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || $('input[name="_token"]').val()
            },
            success: function(response) {
                showToast(response.message || 'Question supprimée avec succès', true);
                setTimeout(() => window.location.reload(), 1500);
            },
            error: function(xhr) {
                showToast(xhr.responseJSON?.message || 'Erreur lors de la suppression', false);
            }
        });
    }

    function removeImage() {
        $('#imagePreviewContainer').addClass('hidden');
        $('#imagePreview').attr('src', '');
        $('#questionImage').val('');
        $('#removeImageFlag').val('1');
    }

    function showToast(message, isSuccess = true) {
        const toast = $('#successToast');
        const toastMessage = $('#successMessage');
        const toastIcon = toast.find('i');

        toastMessage.text(message);
        toast.removeClass('hidden bg-green-500 bg-red-500');
        toastIcon.removeClass('fa-check-circle fa-exclamation-circle');

        if (isSuccess) {
            toast.addClass('bg-green-500');
            toastIcon.addClass('fa-check-circle');
        } else {
            toast.addClass('bg-red-500');
            toastIcon.addClass('fa-exclamation-circle');
        }

        toast.fadeIn();

        setTimeout(() => {
            toast.fadeOut(() => toast.addClass('hidden'));
        }, 3000);
    }

    function displayValidationErrors(errors) {
        $('.error-message').remove();
        $('.border-red-500').removeClass('border-red-500');

        $.each(errors, function(key, value) {
            let elementId = key.replace(/\./g, '_').replace(/\[/g, '_').replace(/\]/g, '');
            let $element = $(`#${elementId}, [name="${key}"]`).first();
            
            if (key.startsWith('choices.')) {
                 const match = key.match(/choices\.(\d+)\.text/);
                 if (match) {
                     const index = match[1];
                     $element = $(`input[name="choices[${index}][text]"]`);
                 }
            } else if (key === 'correct_choice') {
                 $element = $('#choicesContainer');
            }

            if ($element.length) {
                $element.addClass('border-red-500');
                const errorHtml = `<p class="error-message text-red-500 text-xs mt-1">${value[0]}</p>`;
                if (key === 'correct_choice') {
                     $element.after(errorHtml);
                } else {
                     $element.after(errorHtml);
                }
            } else {
                 console.warn(`Could not find element for error key: ${key}`);
            }
        });
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
                 $('#imagePreviewContainer').addClass('hidden');
                 $('#imagePreview').attr('src', '');
            }
        });

        $('#addChoiceBtn').click(function() {
            addChoiceToForm();
        });

        $('#choicesContainer').on('click', '.remove-choice-btn', function() {
            if ($(this).prop('disabled')) return;

            const $container = $('#choicesContainer');
            if ($container.children().length <= 2) {
                showToast('Minimum 2 choix requis', false);
                return;
            }

            const $choiceItem = $(this).closest('.choice-item');
            const $radio = $choiceItem.find('input[type="radio"]');

            if ($radio.prop('checked')) {
                const $firstRadio = $container.find('input[type="radio"]').first();
                if ($firstRadio.length && $firstRadio[0] !== $radio[0]) {
                     $firstRadio.prop('checked', true);
                } else {
                     const $secondRadio = $container.find('input[type="radio"]').eq(1);
                     if ($secondRadio.length) {
                         $secondRadio.prop('checked', true);
                     }
                }
            }

            $choiceItem.remove();
            
            $container.children().each(function(index) {
                 $(this).find('input[type="radio"]').val(index).attr('id', `correct_choice_${index}`);
                 $(this).find('input[type="text"]').attr('name', `choices[${index}][text]`).attr('placeholder', `Texte du choix ${index + 1}`);
                 $(this).find('input[type="hidden"]').attr('name', `choices[${index}][id]`);
            });

            updateRemoveButtons();
        });

        $('#cancelQuestionBtn').click(function() {
            closeModal('questionModal');
        });

        $('#questionForm').submit(function(e) {
            e.preventDefault();

            const $form = $(this);
            const formData = new FormData(this);
            const $submitBtn = $form.find('button[type="submit"]');
            const originalBtnText = $submitBtn.html();
            const method = $form.find('input[name="_method"]').val() || $form.attr('method');

            $('.error-message').remove();
            $('.border-red-500').removeClass('border-red-500');

            if (!$form.find('input[name="correct_choice"]:checked').length) {
                showToast('Veuillez sélectionner une réponse correcte', false);
                const $choicesContainer = $('#choicesContainer');
                $choicesContainer.addClass('border-red-500');
                $choicesContainer.after('<p class="error-message text-red-500 text-xs mt-1">Une réponse correcte doit être sélectionnée.</p>');
                return;
            }

            $submitBtn.prop('disabled', true);
            $submitBtn.html('<i class="fas fa-spinner fa-spin mr-2"></i> Enregistrement...');

            $.ajax({
                url: $form.attr('action'),
                method: method,
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || $('input[name="_token"]').val(),
                    'Accept': 'application/json'
                },
                success: function(response) {
                    showToast(response.message || 'Opération réussie', true);
                    closeModal('questionModal');
                    setTimeout(() => window.location.reload(), 1500);
                },
                error: function(xhr) {
                    if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                        displayValidationErrors(xhr.responseJSON.errors);
                        showToast('Veuillez corriger les erreurs dans le formulaire.', false);
                    } else {
                        showToast(xhr.responseJSON?.message || 'Erreur lors de l\'enregistrement. Veuillez réessayer.', false);
                    }
                },
                complete: function() {
                    $submitBtn.prop('disabled', false);
                    $submitBtn.html(originalBtnText);
                }
            });
        });

        $('.modal-content').on('click', function(e) {
             e.stopPropagation();
        });
        $('#questionDetailsModal, #questionModal').on('click', function(e) {
             if (e.target === this) {
                 closeModal(this.id);
             }
        });

        $(document).keydown(function(e) {
             if (e.key === "Escape") {
                 if (!$('#questionDetailsModal').hasClass('hidden')) {
                     closeModal('questionDetailsModal');
                 }
                 if (!$('#questionModal').hasClass('hidden')) {
                     closeModal('questionModal');
                 }
             }
        });
    });
</script>
@endsection