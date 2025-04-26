{{-- resources/views/candidats/cours.blade.php --}}
@extends('layouts.candidats')

@section('content')
<div class="flex-1 overflow-auto">
    <div class="min-h-screen">
        <header class="bg-[#4D44B5] text-white shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold">Cours: {{ $title->name }}</h1>
                    <p class="mt-1 text-sm opacity-90">Permis {{ $title->type_permis }}</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-right">
                        <span class="block text-sm font-medium text-white">Progression</span>
                        <span class="block text-lg font-bold">{{ $progress['percentage'] }}%</span>
                    </div>
                    <div class="w-32 bg-white bg-opacity-20 rounded-full h-2.5">
                        <div class="bg-white h-2.5 rounded-full" style="width: {{ $progress['percentage'] }}%"></div>
                    </div>
                </div>
            </div>
        </header>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex justify-between items-center mb-6">
                <a href="{{ route('candidats.titres') }}" 
                   class="bg-[#4D44B5] text-white px-4 py-2 rounded-lg font-medium hover:bg-[#3a32a1] transition inline-flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Retour
                </a>
                
                <form action="{{ route('candidats.cours', $title) }}" method="GET" class="relative w-full md:w-64 ml-4">
                    <input type="text" name="search" placeholder="Rechercher un cours..." value="{{ $searchTerm }}"
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#4D44B5] focus:border-transparent">
                    <i class="fas fa-search absolute left-3 top-2.5 text-gray-400"></i>
                    @if($searchTerm)
                    <a href="{{ route('candidats.cours', $title) }}" class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </a>
                    @endif
                </form>
            </div>
        </div>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($courses as $course)
                <div class="bg-white border rounded-lg p-4 hover:shadow-md transition transform hover:-translate-y-1">
                    <div class="mb-4 h-40 bg-gray-100 rounded-lg overflow-hidden">
                        @if($course->image)
                            <img src="{{ asset('storage/' . $course->image) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <i class="fas fa-book-open text-4xl"></i>
                            </div>
                        @endif
                    </div>
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-lg font-semibold text-[#4D44B5]">{{ $course->title }}</h3>
                        @if($course->views_count > 0)
                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">
                            <i class="fas fa-check-circle mr-1"></i> Vu
                        </span>
                        @endif
                    </div>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $course->description }}</p>
                    <button onclick="showCourseDetail({{ $course->id }})"
                            class="w-full text-center bg-[#4D44B5] hover:bg-[#3a32a1] text-white font-medium py-2 px-4 rounded-lg transition flex items-center justify-center">
                        <i class="fas fa-eye mr-2"></i> Voir le cours
                    </button>
                </div>
                @empty
                <div class="col-span-3 text-center py-10">
                    <div class="bg-white rounded-xl shadow-md p-8">
                        <i class="fas fa-book-open text-4xl text-gray-300 mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-700 mb-2">
                            @if($searchTerm)
                                Aucun cours trouvé pour "{{ $searchTerm }}"
                            @else
                                Aucun cours disponible
                            @endif
                        </h3>
                        @if($searchTerm)
                        <a href="{{ route('candidats.cours', $title) }}" class="mt-4 inline-block text-[#4D44B5] hover:text-[#3a32a1] font-medium">
                            <i class="fas fa-undo-alt mr-2"></i> Réinitialiser
                        </a>
                        @endif
                    </div>
                </div>
                @endforelse
            </div>
        </main>
    </div>
</div>

<!-- Modal -->
<div id="courseDetailModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full bg-black bg-opacity-50">
    <div class="relative w-full max-w-2xl max-h-full mx-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-900" id="courseModalTitle"></h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="courseDetailModal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Fermer</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-6 space-y-4">
                <div class="h-64 bg-gray-100 rounded-lg overflow-hidden mb-4">
                    {{-- <img id="courseModalImage" class="w-full h-full object-cover" src="" onerror="this.src='{{ asset('images/') }}'"> --}}
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-gray-700 whitespace-pre-line" id="courseModalDescription"></p>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b">
                <button data-modal-hide="courseDetailModal" type="button" class="text-white bg-[#4D44B5] hover:bg-[#3a32a1] focus:ring-4 focus:outline-none focus:ring-[#4D44B5] font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Fermer
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.6/dist/flowbite.min.js"></script>
<script>
    function showCourseDetail(courseId) {
        fetch(`/candidats/cours/${courseId}/detail`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur réseau');
                }
                return response.json();
            })
            .then(data => {
                // Mettre à jour le modal
                document.getElementById('courseModalTitle').textContent = data.title;
                document.getElementById('courseModalDescription').textContent = data.description;
                document.getElementById('courseModalImage').src = data.image;
                
                // Afficher le modal
                const modal = new Modal(document.getElementById('courseDetailModal'));
                modal.show();
                
                // Actualiser les indicateurs de vue
                const viewedBadges = document.querySelectorAll(`[data-course-id="${courseId}"] .view-indicator`);
                viewedBadges.forEach(badge => badge.classList.remove('hidden'));
                
                // Actualiser la progression dans l'en-tête
                if (data.progress) {
                    const progressPercentage = document.querySelector('header .text-lg.font-bold');
                    const progressBar = document.querySelector('header .h-2.5 > div');
                    
                    if (progressPercentage && progressBar) {
                        progressPercentage.textContent = `${data.progress.percentage}%`;
                        progressBar.style.width = `${data.progress.percentage}%`;
                    }
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Une erreur est survenue lors du chargement du cours');
            });
    }
</script>
@endsection