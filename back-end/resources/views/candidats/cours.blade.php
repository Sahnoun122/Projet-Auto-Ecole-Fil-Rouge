@extends('layouts.candidats')

@section('content')
<div class="flex-1 overflow-auto bg-gray-50">
    <div class="min-h-screen">
        <header class="bg-gradient-to-r from-[#4D44B5] to-[#6059c9] text-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
                    <div>
                        <h1 class="text-3xl font-bold">{{ $title->name }}</h1>
                        <p class="mt-2 text-blue-100">
                            <i class="fas fa-car mr-1"></i> Permis {{ $title->type_permis }}
                        </p>
                    </div>
                    <div class="w-full md:w-auto bg-white bg-opacity-10 rounded-lg p-4">
                        <div class="flex items-center space-x-4">
                            <div class="text-right">
                                <span class="block text-sm font-medium text-blue-100">Progression</span>
                                <span id="progress-text" class="block text-2xl font-bold">{{ $progress['percentage'] }}%</span>
                            </div>
                            <div class="w-40 bg-white bg-opacity-20 rounded-full h-3">
                                <div id="progress-bar" class="bg-white h-3 rounded-full transition-all duration-500" style="width: {{ $progress['percentage'] }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white rounded-xl shadow-sm p-4">
                <a href="{{ route('candidats.titres') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition">
                    <i class="fas fa-arrow-left mr-2"></i> Retour aux titres
                </a>
                
                <form action="{{ route('candidats.cours', $title) }}" method="GET" class="w-full md:w-96">
                    <div class="relative">
                        <input type="text" name="search" placeholder="Rechercher un cours..." value="{{ $searchTerm ?? '' }}"
                               class="w-full pl-10 pr-10 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#4D44B5] focus:border-transparent">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        @if($searchTerm)
                        <a href="{{ route('candidats.cours', $title) }}" class="absolute right-3 top-3 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times"></i>
                        </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($courses as $course)
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300" data-course-id="{{ $course->id }}">
                    <div class="relative h-48 bg-gray-100 rounded-t-xl overflow-hidden group">
                        @if($course->image)
                            <img src="{{ asset('storage/' . $course->image) }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                 alt="{{ $course->title }}">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <i class="fas fa-book-open text-5xl"></i>
                            </div>
                        @endif
                        
                        @if($course->views_count > 0)
                        <div class="absolute top-3 right-3 bg-green-500 text-white text-xs px-3 py-1 rounded-full shadow view-indicator">
                            <i class="fas fa-check-circle mr-1"></i> Vu
                        </div>
                        @endif
                    </div>
                    
                    <div class="p-5">
                        <h3 class="text-xl font-semibold text-[#4D44B5] mb-2">{{ $course->title }}</h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $course->description }}</p>
                        
                        <button onclick="showCourseDetail({{ $course->id }})"
                                class="w-12 h-12 flex items-center justify-center mx-auto bg-[#4D44B5] hover:bg-[#3a32a1] text-white rounded-full transition-all duration-300 hover:shadow-lg hover:scale-110">
                            <i class="fas fa-eye text-lg"></i>
                        </button>
                    </div>
                </div>
                @empty
                <div class="col-span-full">
                    <div class="bg-white rounded-xl shadow-sm p-8 text-center">
                        <i class="fas fa-book-open text-6xl text-gray-300 mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-700 mb-2">
                            @if($searchTerm)
                                Aucun cours trouvé pour "{{ $searchTerm }}"
                            @else
                                Aucun cours disponible
                            @endif
                        </h3>
                        @if($searchTerm)
                        <a href="{{ route('candidats.cours', $title) }}" class="mt-4 inline-block text-[#4D44B5] hover:text-[#3a32a1] font-medium">
                            <i class="fas fa-undo-alt mr-2"></i> Réinitialiser la recherche
                        </a>
                        @endif
                    </div>
                </div>
                @endforelse
            </div>
        </main>
    </div>
</div>

<div id="courseDetailModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-75" 
             onclick="closeModal()"></div>
        
        <div class="relative inline-block w-full max-w-3xl overflow-hidden text-left align-bottom transition-all transform bg-white rounded-xl shadow-xl sm:my-8 sm:align-middle">
            <div class="absolute top-0 right-0 pt-4 pr-4">
                <button type="button" 
                        onclick="closeModal()" 
                        class="text-gray-400 hover:text-gray-500 transition-colors">
                    <span class="sr-only">Fermer</span>
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <div class="bg-white px-6 pt-6 pb-8">
                <div id="modal-image-container" class="mb-6 rounded-xl overflow-hidden"></div>
                
                <h3 class="text-2xl font-bold text-gray-900 mb-4" id="modal-title"></h3>
                
                <div class="prose max-w-none">
                    <p class="text-gray-600 whitespace-pre-line" id="modal-description"></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showCourseDetail(courseId) {
    fetch(`/candidats/cours/${courseId}/detail`)
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => Promise.reject(err));
            }
            return response.json();
        })
        .then(data => {
            document.getElementById('modal-title').textContent = data.title;
            document.getElementById('modal-description').textContent = data.description;
            
            const imageContainer = document.getElementById('modal-image-container');
            imageContainer.innerHTML = '';
            
            if (data.image) {
                const img = document.createElement('img');
                img.src = data.image;
                img.className = 'w-full h-80 object-cover';
                img.onerror = function() {
                    this.style.display = 'none';
                    const placeholder = document.createElement('div');
                    placeholder.className = 'w-full h-80 bg-gray-100 flex items-center justify-center';
                    placeholder.innerHTML = '<i class="fas fa-book-open text-6xl text-gray-400"></i>';
                    imageContainer.appendChild(placeholder);
                };
                imageContainer.appendChild(img);
            } else {
                const placeholder = document.createElement('div');
                placeholder.className = 'w-full h-80 bg-gray-100 flex items-center justify-center';
                placeholder.innerHTML = '<i class="fas fa-book-open text-6xl text-gray-400"></i>';
                imageContainer.appendChild(placeholder);
            }
            
            document.getElementById('courseDetailModal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
            
            const courseElement = document.querySelector(`[data-course-id="${courseId}"]`);
            if (courseElement) {
                let viewIndicator = courseElement.querySelector('.view-indicator');
                if (!viewIndicator) {
                    const container = courseElement.querySelector('.relative');
                    if (container) {
                        viewIndicator = document.createElement('div');
                        viewIndicator.className = 'absolute top-3 right-3 bg-green-500 text-white text-xs px-3 py-1 rounded-full shadow view-indicator';
                        viewIndicator.innerHTML = '<i class="fas fa-check-circle mr-1"></i> Vu';
                        container.appendChild(viewIndicator);
                    }
                }
            }
            
            if (data.progress) {
                document.getElementById('progress-text').textContent = `${data.progress.percentage}%`;
                document.getElementById('progress-bar').style.width = `${data.progress.percentage}%`;
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert(error.error || 'Une erreur est survenue lors du chargement du cours');
        });
}

function closeModal() {
    document.getElementById('courseDetailModal').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeModal();
    }
});
</script>
@endsection