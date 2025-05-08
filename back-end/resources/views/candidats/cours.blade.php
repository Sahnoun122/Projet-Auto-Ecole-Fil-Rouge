@extends('layouts.candidats')

@section('content')
<div class="flex-1 overflow-auto p-4 md:p-6">
    <div class="min-h-screen">
        <header class="bg-[#4D44B5] text-white shadow-md rounded-lg mb-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col sm:flex-row justify-between items-center gap-3">
                <h1 class="text-xl sm:text-2xl font-bold text-center sm:text-left">Catégories de Cours (Permis {{ $title->type_permis }})</h1>
                <div class="w-full sm:w-auto bg-white bg-opacity-10 rounded-lg p-3">
                    <div class="flex items-center space-x-3">
                        <div class="text-right">
                            <span class="block text-xs font-medium text-blue-100">Progression</span>
                            <span id="progress-text" class="block text-lg font-bold">{{ $progress['percentage'] }}%</span>
                        </div>
                        <div class="w-32 bg-white bg-opacity-20 rounded-full h-2.5">
                            <div id="progress-bar" class="bg-white h-2.5 rounded-full transition-all duration-500" style="width: {{ $progress['percentage'] }}%"></div>
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
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 relative" data-course-id="{{ $course->id }}">
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
                    
                    <div class="p-5 pb-16">
                        <h3 class="text-lg font-semibold text-[#4D44B5] mb-2">{{ $course->title }}</h3>
                    </div>
                    
                    <button onclick="showCourseDetails('{{ addslashes($course->title) }}', `{{ addslashes($course->description) }}`, '{{ $course->image ? asset('storage/' . $course->image) : '' }}')"
                            class="absolute bottom-5 right-5 w-12 h-12 flex items-center justify-center center text-[#4D44B5] hover:text-[#3a32a1] rounded-full transition-all duration-300 hover:scale-110">
                        <i class="fas fa-eye text-lg"></i>
                    </button>
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

<!-- Modal de détails (similaire à l'admin) -->
<div id="detailModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-black bg-opacity-50">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-lg">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-900" id="detailModalTitle"></h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-toggle="detailModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Fermer</span>
                </button>
            </div>
            <div class="p-4 md:p-5 space-y-4">
                <div class="flex justify-center items-center mb-4">
                    <img id="detailModalImage" 
                         class="max-w-full h-auto max-h-80 object-contain rounded shadow-md bg-gray-100" 
                         src="" 
                         alt="Image du cours"
                         style="display: none;">
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-semibold mb-2 text-gray-800">Description :</h4>
                    <p class="text-gray-700 whitespace-pre-line" id="detailModalDescription"></p>
                </div>
            </div>
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b">
                <button type="button" onclick="closeDetailModal()" class="text-white bg-[#4D44B5] hover:bg-[#3a32a1] focus:ring-4 focus:outline-none focus:ring-[#4D44B5] font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Fermer
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.6/dist/flowbite.min.js"></script>
<script>
function showCourseDetails(title, description, imageUrl) {
    $('#detailModalTitle').text(title);
    $('#detailModalDescription').text(description);
    
    const imgElement = $('#detailModalImage');
    if (imageUrl && imageUrl !== '') {
        imgElement.attr('src', imageUrl).show();
        imgElement.on('error', function() {
            $(this).hide();
        });
    } else {
        imgElement.hide();
    }
    
    $('#detailModal').removeClass('hidden');
    $('body').addClass('overflow-hidden');
    
    const courseId = $(event.currentTarget).closest('[data-course-id]').data('course-id');
    if (courseId) {
        markCourseAsViewed(courseId);
    }
}

function closeDetailModal() {
    $('#detailModal').addClass('hidden');
    $('body').removeClass('overflow-hidden');
}

function markCourseAsViewed(courseId) {
    $.ajax({
        url: `/candidats/cours/${courseId}/view`,
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            const courseElement = $(`[data-course-id="${courseId}"]`);
            if (courseElement.find('.view-indicator').length === 0) {
                courseElement.find('.relative').append(`
                    <div class="absolute top-3 right-3 bg-green-500 text-white text-xs px-3 py-1 rounded-full shadow view-indicator">
                        <i class="fas fa-check-circle mr-1"></i> Vu
                    </div>
                `);
            }
            
            if (response.progress) {
                $('#progress-text').text(`${response.progress.percentage}%`);
                $('#progress-bar').css('width', `${response.progress.percentage}%`);
            }
        },
        error: function(xhr) {
            console.error('Erreur lors de l\'enregistrement de la vue', xhr.responseText);
        }
    });
}

$(document).keydown(function(event) {
    if (event.key === 'Escape') {
        closeDetailModal();
    }
});

$('#detailModal').click(function(event) {
    if ($(event.target).is('#detailModal')) {
        closeDetailModal();
    }
});
</script>
@endsection