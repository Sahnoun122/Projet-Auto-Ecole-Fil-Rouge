@extends('layouts.candidats')

@section('content')
<div class="flex-1 overflow-auto p-4 md:p-6">
    <div class="min-h-screen">
        <header class="bg-[#4D44B5] text-white shadow-md rounded-lg mb-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col sm:flex-row justify-between items-center gap-3">
                <h1 class="text-xl sm:text-2xl font-bold text-center sm:text-left">Quiz (Permis {{ $typePermis }})</h1>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 bg-white rounded-xl shadow-sm p-4">
                <div class="w-full md:w-auto">
                    <nav class="flex space-x-2 bg-gray-100 p-1 rounded-lg shadow-inner">
                        <button onclick="switchTab('quizzes')" 
                                class="{{ $activeTab === 'quizzes' ? 'bg-[#4D44B5] text-white shadow-sm' : 'text-gray-600 hover:text-[#4D44B5]' }} px-3 py-1.5 rounded-md font-medium text-sm transition-all duration-200">
                            Quiz disponibles
                        </button>
                        <button onclick="switchTab('history')" 
                                class="{{ $activeTab === 'history' ? 'bg-[#4D44B5] text-white shadow-sm' : 'text-gray-600 hover:text-[#4D44B5]' }} px-3 py-1.5 rounded-md font-medium text-sm transition-all duration-200">
                            Historique
                        </button>
                    </nav>
                </div>
                
                <form action="{{ route('candidats.quizzes') }}" method="GET" class="w-full md:w-80">
                    <input type="hidden" name="tab" value="{{ $activeTab }}">
                    <div class="relative">
                        <input 
                            type="text" 
                            name="search" 
                            placeholder="Rechercher un quiz..." 
                            value="{{ request('search') }}"
                            class="w-full pl-10 pr-10 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#4D44B5] focus:border-transparent"
                        >
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        @if(request('search'))
                        <a 
                            href="{{ route('candidats.quizzes', ['tab' => $activeTab]) }}" 
                            class="absolute right-3 top-3 text-gray-400 hover:text-gray-600"
                        >
                            <i class="fas fa-times"></i>
                        </a>
                        @endif
                    </div>
                </form>
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
                                    <h3 class="text-xl font-bold text-gray-800">{{ $quiz->title }}</h3>
                                </div>
                                <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-medium">
                                    {{ $quiz->questions_count }} questions
                                </span>
                            </div>
                            
                            <p class="mt-3 text-gray-600 text-sm">{{ $quiz->description }}</p>
                            
                            <div class="mt-6">
                                <a href="{{ route('candidats.prepare', $quiz) }}" 
                                class="w-full block text-center bg-[#4D44B5] hover:bg-[#3a32a1] text-white font-medium py-2 px-4 rounded-lg transition transform hover:scale-105">
                                    Commencer le quiz
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
                            Aucun quiz disponible pour le moment
                        @endif
                    </h3>
                    @if(request('search'))
                    <a 
                        href="{{ route('candidats.quizzes') }}" 
                        class="mt-4 inline-block text-[#4D44B5] hover:text-[#3a32a1] font-medium"
                    >
                        Voir tous les quiz
                    </a>
                    @endif
                </div>
                @endif
            </div>

            <div id="historyTab" class="{{ $activeTab === 'history' ? 'block' : 'hidden' }}">
                @if($passedQuizzes->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($passedQuizzes as $quiz)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                        <a href="{{ route('candidats.results', $quiz) }}" class="block h-full">
                            <div class="p-6 h-full flex flex-col">
                                <div class="flex justify-between items-start mb-4">
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-medium 
                                              {{ $quiz->passed ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $quiz->passed ? 'Réussi' : 'Échoué' }}
                                    </span>
                                    <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-medium">
                                        {{ $quiz->questions_count }} questions
                                    </span>
                                </div>
                                
                                <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $quiz->title }}</h3>
                                <p class="text-gray-600 text-sm mb-4">{{ $quiz->description }}</p>
                                
                                <div class="mt-auto">
                                    <div class="mb-3">
                                        <div class="flex justify-between text-sm text-gray-600 mb-1">
                                            <span>Score obtenu</span>
                                            <span class="font-medium {{ $quiz->passed ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $quiz->score }}/{{ $quiz->total_questions }}
                                            </span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-{{ $quiz->passed ? 'green' : 'red' }}-500 h-2 rounded-full" 
                                                 style="width: {{ ($quiz->score / $quiz->total_questions) * 100 }}%"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="flex justify-between items-center text-xs text-gray-500">
                                        <span>
                                            <i class="fas fa-car mr-1"></i>
                                            {{ $quiz->type_permis }}
                                        </span>
                                        <span>
                                            <i class="fas fa-calendar-alt mr-1"></i>
                                            {{ $quiz->updated_at->format('d/m/Y') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="bg-white rounded-xl shadow-md p-8 text-center">
                    <i class="fas fa-history text-4xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-700 mb-2">
                        Aucun quiz terminé pour le moment
                    </h3>
                    <p class="text-gray-500 mb-4">
                        Commencez par passer un quiz pour voir vos résultats ici.
                    </p>
                    <button onclick="switchTab('quizzes')" 
                            class="bg-[#4D44B5] hover:bg-[#3a32a1] text-white font-medium py-2 px-4 rounded-lg transition transform hover:scale-105">
                        Voir les quiz disponibles
                    </button>
                </div>
                @endif
            </div>
        </main>
    </div>
</div>

<script>
    function switchTab(tabName) {
        document.getElementById('quizzesTab').classList.add('hidden');
        document.getElementById('historyTab').classList.add('hidden');
        
        document.getElementById(tabName + 'Tab').classList.remove('hidden');
        
        const url = new URL(window.location.href);
        url.searchParams.set('tab', tabName);
        window.history.pushState({}, '', url);
        
        document.querySelector('input[name="tab"]').value = tabName;
    }

    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(() => {
            const cards = document.querySelectorAll('#quizzesTab .grid > div, #historyTab .grid > div');
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