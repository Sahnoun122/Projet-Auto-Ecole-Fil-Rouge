@extends('layouts.admin')

@section('content')
<div class="flex-1 overflow-auto p-4 md:p-6">
    <header class="bg-[#4D44B5] text-white shadow-md rounded-lg mb-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col md:flex-row justify-between items-center">
            <h1 class="text-2xl font-bold mb-2 md:mb-0">Gestion des Quiz</h1>
            @if($activeTab === 'quizzes')
            <button id="newQuizBtn"
                class="bg-white text-[#4D44B5] px-4 py-2 rounded-lg font-medium hover:bg-gray-100 transition flex items-center">
                <i class="fas fa-plus mr-2"></i> Nouveau Quiz
            </button>
            @endif
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 bg-white p-4 rounded-xl shadow">
            <nav class="flex flex-wrap space-x-1 bg-gray-100 p-1 rounded-lg mb-4 md:mb-0">
                <button onclick="switchTab('quizzes')"
                        class="{{ $activeTab === 'quizzes' ? 'bg-[#4D44B5] text-white shadow-sm' : 'text-gray-600 hover:text-[#4D44B5]' }} px-4 py-2 rounded-md font-medium text-sm transition-all duration-200 flex-shrink-0">
                    <i class="fas fa-list mr-1"></i> Mes Quiz
                </button>
                <button onclick="switchTab('results')"
                        class="{{ $activeTab === 'results' ? 'bg-[#4D44B5] text-white shadow-sm' : 'text-gray-600 hover:text-[#4D44B5]' }} px-4 py-2 rounded-md font-medium text-sm transition-all duration-200 flex-shrink-0">
                    <i class="fas fa-chart-bar mr-1"></i> Résultats
                </button>
            </nav>
            
            <form action="{{ route('admin.quizzes') }}" method="GET" class="relative w-full md:w-auto">
                <input type="hidden" name="tab" value="{{ $activeTab }}">
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Rechercher un quiz..." 
                    value="{{ request('search') }}"
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#4D44B5] focus:border-transparent text-sm"
                >
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </form>
        </div>

        <div id="quizzesTab" class="{{ $activeTab === 'quizzes' ? 'block' : 'hidden' }}">
            @if($quizzes->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($quizzes as $quiz)
                <div class="bg-white rounded-xl shadow overflow-hidden border border-gray-100 hover:shadow-lg transition-shadow duration-300 flex flex-col h-full">
                    <div class="p-5 flex-grow">
                        <div class="flex justify-between items-start mb-3">
                            <span class="inline-block px-3 py-1 bg-purple-100 text-[#4D44B5] text-xs font-semibold rounded-full">
                                Permis {{ $quiz->type_permis }}
                            </span>
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-medium">
                                {{ $quiz->questions_count }} {{ Str::plural('question', $quiz->questions_count) }}
                            </span>
                        </div>
                        <a href="{{ route('admin.questions.index' , $quiz->id )}}" class="block mb-2">
                            <h3 class="text-lg font-bold text-gray-800 hover:text-[#4D44B5] transition-colors">{{ $quiz->title }}</h3>
                        </a>
                        <p class="text-gray-600 text-sm line-clamp-3">{{ $quiz->description ?: 'Aucune description fournie.' }}</p>
                    </div>
                    <div class="bg-gray-50 px-5 py-3 border-t border-gray-100 flex justify-between items-center">
                        <div class="flex space-x-1">
                            <button onclick="handleEditQuiz('{{ $quiz->id }}', '{{ $quiz->type_permis }}', '{{ $quiz->title }}', `{{ $quiz->description }}`)"
                                class="text-gray-500 hover:text-[#4D44B5] p-2 rounded-full hover:bg-gray-200 transition" title="Modifier">
                                <i class="fas fa-edit fa-fw"></i>
                            </button>
                            <button onclick="handleDeleteQuiz('{{ $quiz->id }}')"
                                class="text-gray-500 hover:text-red-600 p-2 rounded-full hover:bg-red-50 transition" title="Supprimer">
                                <i class="fas fa-trash fa-fw"></i>
                            </button>
                        </div>
                        <a href="{{ route('admin.results', $quiz) }}" 
                           class="text-sm text-[#4D44B5] hover:underline font-medium">
                            Résultats <i class="fas fa-arrow-right text-xs ml-1"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="bg-white rounded-xl shadow p-8 text-center border border-gray-100">
                <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-book-open text-3xl text-gray-400"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-700 mb-1">
                    @if(request('search'))
                        Aucun quiz trouvé pour "{{ request('search') }}"
                    @else
                        Aucun quiz créé pour le moment
                    @endif
                </h3>
                <p class="text-gray-500 text-sm mb-4">Commencez par ajouter un nouveau quiz.</p>
                @if(request('search'))
                <a href="{{ route('admin.quizzes', ['tab' => 'quizzes']) }}" 
                   class="mt-2 inline-block text-sm text-[#4D44B5] hover:underline font-medium">
                    Voir tous les quiz
                </a>
                @else
                 <button id="newQuizBtnEmpty" 
                    class="mt-2 bg-[#4D44B5] text-white px-4 py-2 rounded-lg font-medium hover:bg-[#3a32a1] transition text-sm">
                    <i class="fas fa-plus mr-1"></i> Créer un Quiz
                </button>
                @endif
            </div>
            @endif
        </div>

        <div id="resultsTab" class="{{ $activeTab === 'results' ? 'block' : 'hidden' }}">
            @if($passedQuizzes->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($passedQuizzes as $quiz)
                <div class="bg-white rounded-xl shadow overflow-hidden border border-gray-100 hover:shadow-lg transition-shadow duration-300 flex flex-col h-full">
                    <div class="p-5 flex-grow">
                        <div class="flex justify-between items-start mb-3">
                            <span class="inline-block px-3 py-1 bg-purple-100 text-[#4D44B5] text-xs font-semibold rounded-full">
                                Permis {{ $quiz->type_permis }}
                            </span>
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-medium">
                                {{ $quiz->questions_count }} {{ Str::plural('question', $quiz->questions_count) }}
                            </span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $quiz->title }}</h3>
                        <p class="text-gray-600 text-sm line-clamp-3 mb-4">{{ $quiz->description ?: 'Aucune description fournie.' }}</p>
                    </div>
                    <div class="bg-gray-50 px-5 py-3 border-t border-gray-100 flex justify-between items-center">
                        <a href="{{ route('admin.results', $quiz) }}" 
                           class="bg-[#4D44B5] hover:bg-[#3a32a1] text-white px-4 py-2 rounded-lg text-sm font-medium transition flex items-center">
                            <i class="fas fa-users mr-2"></i> Voir candidats
                        </a>
                        <span class="text-xs text-gray-500" title="Dernier passage enregistré pour ce quiz">
                            <i class="far fa-clock mr-1"></i> {{ $quiz->updated_at->diffForHumans() }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="bg-white rounded-xl shadow p-8 text-center border border-gray-100">
                 <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-chart-bar text-3xl text-gray-400"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-700 mb-1">
                    Aucun résultat disponible
                </h3>
                <p class="text-gray-500 text-sm">
                    Les candidats n'ont pas encore passé de quiz ou aucun quiz n'a été configuré.
                </p>
            </div>
            @endif
        </div>
    </main>
</div>

<!-- Add/Edit Quiz Modal -->
<div id="quizModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-gray-900 bg-opacity-60">
    <div class="relative p-4 w-full max-w-lg max-h-full">
        <div class="relative bg-white rounded-lg shadow-xl">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-900" id="modalTitle">
                    Nouveau Quiz
                </h3>
                <button type="button" id="closeModalBtn" class="text-gray-400 bg-transparent hover:bg-gray-200 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Fermer</span>
                </button>
            </div>
            <form id="quizForm" method="POST" enctype="multipart/form-data" class="p-4 md:p-5">
                @csrf
                <input type="hidden" id="quizId" name="id">
                <input type="hidden" id="_method" name="_method" value="POST">

                <div id="formErrorsQuiz" class="hidden mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Erreur !</strong>
                    <span class="block sm:inline">Veuillez corriger les erreurs suivantes :</span>
                    <ul class="mt-2 list-disc list-inside text-sm"></ul>
                </div>

                <div class="grid gap-4 mb-4 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="quizPermisType" class="block mb-2 text-sm font-medium text-gray-900">Type de permis *</label>
                        <select id="quizPermisType" name="type_permis" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                            <option selected value="">Sélectionnez un type</option>
                            <option value="A">Permis A (Moto)</option>
                            <option value="B">Permis B (Voiture)</option>
                            <option value="C">Permis C (Poids lourd)</option>
                            <option value="D">Permis D (Bus)</option>
                            <option value="EB">Permis EB (Remorque)</option>
                        </select>
                        <p class="mt-1 text-xs text-red-600 hidden" id="permisTypeError">Veuillez sélectionner un type de permis.</p>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="quizTitle" class="block mb-2 text-sm font-medium text-gray-900">Titre *</label>
                        <input type="text" id="quizTitle" name="title" maxlength="255"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            placeholder="Ex: Signalisation routière avancée">
                        <p class="mt-1 text-xs text-red-600 hidden" id="titleError">Le titre est requis et doit contenir au moins 3 caractères.</p>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="quizDescription" class="block mb-2 text-sm font-medium text-gray-900">Description (Optionnel)</label>
                        <textarea id="quizDescription" name="description" rows="4"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500"
                            placeholder="Décrivez brièvement le contenu ou l'objectif du quiz"></textarea>
                    </div>
                </div>
                <div class="flex items-center justify-end pt-4 border-t border-gray-200 rounded-b">
                    <button type="button" id="cancelBtn" class="text-gray-600 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-300 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 mr-3">
                        Annuler
                    </button>
                    <button type="submit" id="submitBtn" class="text-white bg-[#4D44B5] hover:bg-[#3a32a1] focus:ring-4 focus:outline-none focus:ring-[#a09ae6] font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function switchTab(tabName) {
        document.getElementById('quizzesTab').classList.add('hidden');
        document.getElementById('resultsTab').classList.add('hidden');
        
        document.getElementById(tabName + 'Tab').classList.remove('hidden');
        
        const url = new URL(window.location.href);
        url.searchParams.set('tab', tabName);
        if (window.history.state?.tab !== tabName) {
            window.history.pushState({tab: tabName}, '', url);
        }
        
        const searchFormTabInput = document.querySelector('form[action="{{ route('admin.quizzes') }}"] input[name="tab"]');
        if (searchFormTabInput) {
            searchFormTabInput.value = tabName;
        }

        document.querySelectorAll('nav button').forEach(button => {
            const isCurrent = button.getAttribute('onclick').includes(`'${tabName}'`);
            button.classList.toggle('bg-[#4D44B5]', isCurrent);
            button.classList.toggle('text-white', isCurrent);
            button.classList.toggle('shadow-sm', isCurrent);
            button.classList.toggle('text-gray-600', !isCurrent);
            button.classList.toggle('hover:text-[#4D44B5]', !isCurrent);
        });

        animateCards(`#${tabName}Tab`);
    }

    function resetQuizFormValidation() {
        $('#formErrorsQuiz').addClass('hidden').find('ul').empty();
        $('#quizPermisType').removeClass('border-red-500').addClass('border-gray-300');
        $('#permisTypeError').addClass('hidden');
        $('#quizTitle').removeClass('border-red-500').addClass('border-gray-300');
        $('#titleError').addClass('hidden');
    }

    function validateQuizForm() {
        let isValid = true;
        const errors = [];
        resetQuizFormValidation();

        const permisType = $('#quizPermisType').val();
        if (!permisType) {
            isValid = false;
            $('#quizPermisType').addClass('border-red-500').removeClass('border-gray-300');
            $('#permisTypeError').removeClass('hidden');
            errors.push('Le type de permis est requis.');
        }

        const titleInput = $('#quizTitle');
        const title = titleInput.val().trim();
        const titleRegex = /\S.*\S.*\S/;
        if (!title || !titleRegex.test(title)) {
            isValid = false;
            titleInput.addClass('border-red-500').removeClass('border-gray-300');
            $('#titleError').removeClass('hidden');
            errors.push('Le titre est requis (minimum 3 caractères).');
        }

        if (!isValid) {
            const errorList = $('#formErrorsQuiz').find('ul');
            errors.forEach(error => {
                errorList.append(`<li>${error}</li>`);
            });
            $('#formErrorsQuiz').removeClass('hidden');
            $('#quizModal .relative.bg-white').scrollTop(0);
        }

        return isValid;
    }

    function animateCards(tabSelector) {
        setTimeout(() => {
            const cards = document.querySelectorAll(`${tabSelector} .grid > div`);
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'opacity 0.4s ease-out, transform 0.4s ease-out';
                
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 80);
            });
        }, 50);
    }

    $(document).ready(function() {
        const modal = $('#quizModal');
        const form = $('#quizForm');
        const submitBtn = $('#submitBtn');

        function openModal() {
            resetQuizFormValidation();
            modal.removeClass('hidden').addClass('flex');
            setTimeout(() => $('#quizPermisType').focus(), 100);
        }

        function closeModal() {
            modal.addClass('hidden').removeClass('flex');
            form[0].reset();
        }

        $('#newQuizBtn, #newQuizBtnEmpty').click(function() {
            $('#modalTitle').text('Nouveau Quiz');
            form.attr('action', "{{ route('admin.quizzes.store') }}");
            $('#_method').val('POST');
            $('#quizId').val('');
            openModal();
        });

        window.handleEditQuiz = function(id, permisType, title, description) {
            $('#modalTitle').text('Modifier Quiz');
            form.attr('action', "{{ url('admin/quizzes') }}/" + id);
            $('#_method').val('PUT');
            $('#quizId').val(id);
            $('#quizPermisType').val(permisType);
            $('#quizTitle').val(title);
            $('#quizDescription').val(description);
            openModal();
        };

        window.handleDeleteQuiz = function(id) {
            if (confirm('Voulez-vous vraiment supprimer ce quiz et toutes ses questions associées ?')) {
                $.ajax({
                    url: "{{ url('admin/quizzes') }}/" + id,
                    method: 'POST',
                    data: { 
                        _method: 'DELETE', 
                        _token: "{{ csrf_token() }}" 
                    },
                    success: function(response) {
                        $(`button[onclick*="handleDeleteQuiz('${id}')"]`).closest('.grid > div').fadeOut(300, function() { $(this).remove(); });
                        console.log(response.message || 'Quiz supprimé avec succès.');
                    },
                    error: function(xhr) {
                        alert('Erreur lors de la suppression: ' + (xhr.responseJSON?.message || 'Une erreur est survenue.'));
                    }
                });
            }
        };

        $('#cancelBtn, #closeModalBtn').click(function() {
            closeModal();
        });

        modal.click(function(event) {
            if ($(event.target).is(modal)) {
                closeModal();
            }
        });

        form.submit(function(e) {
            if (!validateQuizForm()) {
                e.preventDefault();
            }
        });

        const activeTabId = '{{ $activeTab }}';
        animateCards(`#${activeTabId}Tab`);

        window.onpopstate = function(event) {
            const stateTab = event.state?.tab || 'quizzes';
            switchTab(stateTab);
        };
    });
</script>
@endsection