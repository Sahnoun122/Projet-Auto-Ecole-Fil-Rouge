@extends('layouts.candidats')

@section('content')
<div class="flex-1 overflow-auto p-4 md:p-6">
    <div class="min-h-screen">
        <header class="bg-[#4D44B5] text-white shadow-md rounded-lg mb-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col sm:flex-row justify-between items-center gap-3">
                <h1 class="text-xl sm:text-2xl font-bold text-center sm:text-left">Catégories de Cours (Permis {{ $typePermis }})</h1>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <nav class="flex space-x-4 bg-white p-1 rounded-lg shadow-inner">
                    <button 
                        onclick="switchTab('titles')" 
                        @class([
                            'px-4 py-2 rounded-md font-medium text-sm transition-all duration-200',
                            'bg-[#4D44B5] text-white' => $activeTab === 'titles',
                            'text-gray-600 hover:text-[#4D44B5]' => $activeTab !== 'titles',
                        ])>
                        <i class="fas fa-list mr-1"></i> Catégories
                    </button>
                    <button 
                        onclick="switchTab('progress')" 
                        @class([
                            'px-4 py-2 rounded-md font-medium text-sm transition-all duration-200',
                            'bg-[#4D44B5] text-white' => $activeTab === 'progress',
                            'text-gray-600 hover:text-[#4D44B5]' => $activeTab !== 'progress',
                        ])>
                        <i class="fas fa-chart-bar mr-1"></i> Progression
                    </button>
                </nav>
                
                <form action="{{ route('candidats.titres') }}" method="GET" class="relative w-full md:w-64">
                    <input type="hidden" name="tab" value="{{ $activeTab }}">
                    <input type="text" name="search" placeholder="Rechercher..." value="{{ $searchTerm }}"
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#4D44B5] focus:border-transparent">
                    <i class="fas fa-search absolute left-3 top-2.5 text-gray-400"></i>
                    @if($searchTerm)
                    <a href="{{ route('candidats.titres') }}" class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600" aria-label="Réinitialiser la recherche">
                        <i class="fas fa-times"></i>
                    </a>
                    @endif
                </form>
            </div>

            <div id="titlesTab" @class(['hidden' => $activeTab !== 'titles'])>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($titles as $title)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                        <div class="p-6 h-full flex flex-col">
                            <div class="flex-grow">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <span class="inline-block px-3 py-1 bg-purple-100 text-[#4D44B5] text-xs font-medium rounded-full mb-3">
                                            {{ $title->type_permis }}
                                        </span>
                                        <h3 class="text-xl font-bold text-gray-800">{{ $title->name }}</h3>
                                    </div>
                                    <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-medium">
                                        {{ $title->courses_count }} {{ Str::plural('cours', $title->courses_count) }}
                                    </span>
                                </div>
                                <p class="mt-3 text-gray-600 text-sm line-clamp-2">
                                    {{ $title->description ?? 'Aucune description disponible' }}
                                </p>
                            </div>
                            <div class="mt-6">
                                <a href="{{ route('candidats.cours', $title) }}" 
                                   class="w-full block text-center bg-[#4D44B5] hover:bg-[#3a32a1] text-white font-medium py-2 px-4 rounded-lg transition-colors duration-300">
                                   Voir les cours <i class="fas fa-arrow-right ml-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-10">
                        <div class="bg-white rounded-xl shadow-md p-8">
                            <i class="fas fa-book-open text-4xl text-gray-300 mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-700">
                                @if($searchTerm)
                                    Aucune catégorie trouvée pour "{{ $searchTerm }}"
                                @else
                                    Aucune catégorie disponible
                                @endif
                            </h3>
                            @if($searchTerm)
                            <a href="{{ route('candidats.titres') }}" class="mt-4 inline-block text-[#4D44B5] hover:text-[#3a32a1] font-medium">
                                <i class="fas fa-undo-alt mr-2"></i> Réinitialiser
                            </a>
                            @endif
                        </div>
                    </div>
                    @endforelse
                </div>
                @if($titles->hasPages())
                <div class="mt-8">
                    {{ $titles->withQueryString()->links() }}
                </div>
                @endif
            </div>

            <div id="progressTab" @class(['hidden' => $activeTab !== 'progress'])>
                @if($titles->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($titles as $title)
                    @php $progress = $title->getProgressForUser(Auth::id()); @endphp
                    <div class="bg-white rounded-xl shadow-md overflow-hidden p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold text-gray-800">{{ $title->name }}</h3>
                            <span class="px-3 py-1 bg-purple-100 text-[#4D44B5] rounded-full text-xs font-medium">
                                {{ $title->type_permis }}
                            </span>
                        </div>
                        
                        <div class="mb-4">
                            <div class="flex justify-between text-sm text-gray-600 mb-1">
                                <span>Progression</span>
                                <span class="font-medium text-[#4D44B5]">{{ $progress['percentage'] }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-[#4D44B5] h-2.5 rounded-full" style="width: {{ $progress['percentage'] }}%"></div>
                            </div>
                        </div>
                        
                        <div class="text-center text-sm text-gray-500">
                            {{ $progress['viewed'] }} sur {{ $progress['total'] }} cours complétés
                        </div>
                        
                        <a href="{{ route('candidats.cours', $title) }}" 
                           class="mt-4 block text-center text-[#4D44B5] hover:text-[#3a32a1] font-medium">
                           Voir les cours <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="bg-white rounded-xl shadow-md p-8 text-center">
                    <i class="fas fa-book-open text-4xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-700 mb-2">
                        Aucune progression enregistrée
                    </h3>
                    <p class="text-gray-500 mb-4">
                        Commencez par consulter des cours pour voir votre progression.
                    </p>
                    <button onclick="switchTab('titles')" 
                            class="bg-[#4D44B5] hover:bg-[#3a32a1] text-white font-medium py-2 px-4 rounded-lg transition">
                        Voir les catégories
                    </button>
                </div>
                @endif
            </div>
        </main>
    </div>
</div>

<script>
    function switchTab(tabName) {
        const titlesTab = document.getElementById('titlesTab');
        const progressTab = document.getElementById('progressTab');
        const titlesButton = document.querySelector('nav button:first-child');
        const progressButton = document.querySelector('nav button:last-child');
        const activeClasses = ['bg-[#4D44B5]', 'text-white'];
        const inactiveClasses = ['text-gray-600', 'hover:text-[#4D44B5]'];

        if (tabName === 'titles') {
            titlesTab.classList.remove('hidden');
            progressTab.classList.add('hidden');
            titlesButton.classList.add(...activeClasses);
            titlesButton.classList.remove(...inactiveClasses);
            progressButton.classList.add(...inactiveClasses);
            progressButton.classList.remove(...activeClasses);
        } else {
            titlesTab.classList.add('hidden');
            progressTab.classList.remove('hidden');
            titlesButton.classList.add(...inactiveClasses);
            titlesButton.classList.remove(...activeClasses);
            progressButton.classList.add(...activeClasses);
            progressButton.classList.remove(...inactiveClasses);
        }
        
        const url = new URL(window.location.href);
        url.searchParams.set('tab', tabName);
        window.history.pushState({}, '', url);
        document.querySelector('input[name="tab"]').value = tabName;
    }

    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('#titlesTab .grid > div:not(.col-span-3), #progressTab .grid > div');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.4s ease-out, transform 0.4s ease-out';
            
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
    });
</script>
@endsection