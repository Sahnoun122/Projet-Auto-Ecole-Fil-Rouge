@extends('layouts.admin')

@section('content')
<div class="flex-1 overflow-auto">
    <header class="bg-[#4D44B5] text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <h1 class="text-2xl font-bold">QuizMaster Pro</h1>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4 bg-white p-4 rounded-xl shadow">
            <nav class="flex space-x-1 bg-gray-100 p-1 rounded-lg">
                <button onclick="switchTab('quizzes')" 
                        class="{{ $activeTab === 'quizzes' ? 'bg-[#4D44B5] text-white' : 'text-gray-600 hover:text-[#4D44B5]' }} px-4 py-2 rounded-md font-medium text-sm transition-all duration-200">
                    <i class="fas fa-list mr-1"></i> Mes Quiz
                </button>
                <button onclick="switchTab('results')" 
                        class="{{ $activeTab === 'results' ? 'bg-[#4D44B5] text-white' : 'text-gray-600 hover:text-[#4D44B5]' }} px-4 py-2 rounded-md font-medium text-sm transition-all duration-200">
                    <i class="fas fa-chart-bar mr-1"></i> Résultats
                </button>
            </nav>
            
            <div class="flex items-center space-x-4">
                <form action="{{ route('admin.quizzes') }}" method="GET" class="relative">
                    <input type="hidden" name="tab" value="{{ $activeTab }}">
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="Rechercher..." 
                        value="{{ request('search') }}"
                        class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#4D44B5] focus:border-transparent"
                    >
                    <i class="fas fa-search absolute left-3 top-2.5 text-gray-400"></i>
                </form>
                
                @if($activeTab === 'quizzes')
                <button id="newQuizBtn"
                    class="bg-[#4D44B5] text-white px-4 py-2 rounded-lg font-medium hover:bg-[#3a32a1] transition">
                    <i class="fas fa-plus mr-1"></i> Nouveau
                </button>
                @endif
            </div>
        </div>

        <div id="quizzesTab" class="{{ $activeTab === 'quizzes' ? 'block' : 'hidden' }}">
            @if($quizzes->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($quizzes as $quiz)
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="inline-block px-3 py-1 bg-purple-100 text-[#4D44B5] text-xs font-medium rounded-full mb-3">
                                    {{ $quiz->type_permis }}
                                </span>
                                <a href=" {{ route('admin.questions.index' , $quiz->id )}}"><h3 class="text-xl font-bold text-gray-800">{{ $quiz->title }}</h3>                                </a>
                            </div>
                            <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-medium">
                                {{ $quiz->questions_count }} questions
                            </span>
                        </div>
                        
                        <p class="mt-3 text-gray-600 text-sm">{{ $quiz->description }}</p>
                        
                        <div class="mt-6 flex justify-between items-center">
                            <div class="flex space-x-2">
                                <button onclick="handleEditQuiz('{{ $quiz->id }}', '{{ $quiz->type_permis }}', '{{ $quiz->title }}', `{{ $quiz->description }}`)"
                                    class="text-[#4D44B5] hover:text-[#3a32a1] p-2">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button onclick="handleDeleteQuiz('{{ $quiz->id }}')"
                                    class="text-red-500 hover:text-red-700 p-2">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            
                            <a href="{{ route('admin.results', $quiz) }}" 
                               class="text-sm text-[#4D44B5] hover:text-[#3a32a1] font-medium">
                                Voir résultats <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="bg-white rounded-xl shadow-md p-8 text-center">
                <i class="fas fa-book-open text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-700">
                    @if(request('search'))
                        Aucun quiz trouvé pour "{{ request('search') }}"
                    @else
                        Aucun quiz disponible
                    @endif
                </h3>
                @if(request('search'))
                <a href="{{ route('admin.quizzes') }}" 
                   class="mt-4 inline-block text-[#4D44B5] hover:text-[#3a32a1] font-medium">
                    Voir tous les quiz
                </a>
                @endif
            </div>
            @endif
        </div>

        <div id="resultsTab" class="{{ $activeTab === 'results' ? 'block' : 'hidden' }}">
            @if($passedQuizzes->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($passedQuizzes as $quiz)
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <span class="inline-block px-3 py-1 bg-purple-100 text-[#4D44B5] text-xs font-medium rounded-full">
                                {{ $quiz->type_permis }}
                            </span>
                            <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-medium">
                                {{ $quiz->questions_count }} questions
                            </span>
                        </div>
                        
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $quiz->title }}</h3>
                        <p class="text-gray-600 text-sm mb-4">{{ $quiz->description }}</p>
                        
                        <div class="flex justify-between items-center">
                            <a href="{{ route('admin.results', $quiz) }}" 
                               class="bg-[#4D44B5] hover:bg-[#3a32a1] text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                                <i class="fas fa-users mr-1"></i> Voir candidats
                            </a>
                            
                            <span class="text-xs text-gray-500">
                                Dernier passage: {{ $quiz->updated_at->format('d/m/Y') }}
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="bg-white rounded-xl shadow-md p-8 text-center">
                <i class="fas fa-chart-bar text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-700 mb-2">
                    Aucun résultat disponible
                </h3>
                <p class="text-gray-500 mb-4">
                    Les candidats n'ont pas encore passé de quiz.
                </p>
            </div>
            @endif
        </div>
    </main>
</div>

<div id="quizModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50">
    <div class="bg-white w-full max-w-md p-6 rounded-lg shadow-xl">
        <h2 id="modalTitle" class="text-lg font-bold mb-4">Nouveau Quiz</h2>
        <form id="quizForm" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="quizId" name="id">
            <input type="hidden" id="_method" name="_method" value="POST">

            <div class="mb-4">
                <label for="quizPermisType" class="block text-sm font-medium text-gray-700 mb-1">Type de permis *</label>
                <select id="quizPermisType" name="type_permis" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                    <option value="">Sélectionnez un type</option>
                    <option value="A">Permis A (Moto)</option>
                    <option value="B">Permis B (Voiture)</option>
                    <option value="C">Permis C (Poids lourd)</option>
                    <option value="D">Permis D (Bus)</option>
                    <option value="EB">Permis EB (Remorque)</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label for="quizTitle" class="block text-sm font-medium text-gray-700 mb-1">Titre *</label>
                <input type="text" id="quizTitle" name="title" maxlength="255"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
            </div>

            <div class="mb-4">
                <label for="quizDescription" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea id="quizDescription" name="description" rows="3"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]"></textarea>
            </div>
            
            <div class="flex justify-end space-x-2">
                <button type="button" id="cancelBtn"
                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                    Annuler
                </button>
                <button type="submit" id="submitBtn"
                    class="px-4 py-2 bg-[#4D44B5] text-white rounded-lg hover:bg-[#3a32a1] transition">
                    Enregistrer
                </button>
            </div>
        </form>
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
        window.history.pushState({}, '', url);
        
        document.querySelector('input[name="tab"]').value = tabName;
    }

    $(document).ready(function() {
        const modal = $('#quizModal');
        const form = $('#quizForm');
        const submitBtn = $('#submitBtn');

        $('#newQuizBtn').click(function() {
            $('#modalTitle').text('Nouveau Quiz');
            form.attr('action', "{{ route('admin.quizzes.store') }}");
            $('#_method').val('POST');
            $('#quizId').val('');
            $('#quizPermisType').val('');
            $('#quizTitle').val('');
            $('#quizDescription').val('');
            modal.removeClass('hidden');
        });

        window.handleEditQuiz = function(id, permisType, title, description) {
            $('#modalTitle').text('Modifier Quiz');
            form.attr('action', "{{ route('admin.quizzes.update', '') }}/" + id);
            $('#_method').val('PUT');
            $('#quizId').val(id);
            $('#quizPermisType').val(permisType);
            $('#quizTitle').val(title);
            $('#quizDescription').val(description);
            modal.removeClass('hidden');
        };

        window.handleDeleteQuiz = function(id) {
            if (confirm('Voulez-vous vraiment supprimer ce quiz ?')) {
                $.ajax({
                    url: "{{ route('admin.quizzes.destroy', '') }}/" + id,
                    method: 'POST',
                    data: { 
                        _method: 'DELETE', 
                        _token: "{{ csrf_token() }}" 
                    },
                    success: function() {
                        window.location.reload();
                    },
                    error: function(xhr) {
                        alert('Erreur lors de la suppression: ' + xhr.responseJSON?.message);
                    }
                });
            }
        };

        $('#cancelBtn').click(function() {
            modal.addClass('hidden');
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(() => {
            const cards = document.querySelectorAll('#quizzesTab .grid > div, #resultsTab .grid > div');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'all 0.4s ease-out';
                
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        }, 300);
    });
</script>
@endsection