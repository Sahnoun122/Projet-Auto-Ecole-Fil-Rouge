@extends('layouts.candidats')

@section('content')
<div class="flex-1 overflow-auto">
    <header class="bg-[#4D44B5] text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold">Cours pour: {{ $title->name }}</h1>
                <p class="mt-1 text-sm opacity-90">Explorez les cours pour votre formation</p>
            </div>
            <span class="inline-block px-3 py-1 bg-white text-[#4D44B5] rounded-full text-sm font-medium">
                Permis {{ $title->type_permis }}
            </span>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <a href="{{ url()->previous() }}"
            class="bg-[#4D44B5] text-white px-4 py-2 rounded-lg font-medium hover:bg-[#3a32a1] transition inline-flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Retour
        </a>
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
                        <i class="fas fa-image text-4xl"></i>
                    </div>
                @endif
            </div>
            <h3 class="text-lg font-semibold text-[#4D44B5] mb-2">{{ $course->title }}</h3>
            <div class="flex justify-between items-center">
                <button data-modal-target="detailModal" data-modal-toggle="detailModal"
                    onclick="showCourseDetails('{{ $course->title }}', '{{ $course->description }}', '{{ $course->image ? asset('storage/' . $course->image) : '' }}')"
                    class="text-gray-600 hover:text-[#4D44B5] p-1" title="Voir les détails">
                    <i class="fas fa-eye"></i>
                </button>
             
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-10">
            <div class="bg-white rounded-xl shadow-md p-8">
                <i class="fas fa-book-open text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-700 mb-2">
                    Aucun cours disponible dans cette catégorie
                </h3>
                <p class="text-gray-500">Veuillez vérifier ultérieurement.</p>
            </div>
        </div>
        @endforelse
    </div>
</div>

<!-- Course Details Modal -->
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
                <div class="h-64 bg-gray-100 rounded-lg overflow-hidden mb-4">
                    <img id="detailModalImage" class="w-full h-full object-cover" src="" onerror="this.src='{{ asset('images/default-course.jpg') }}'">
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-gray-700 whitespace-pre-line" id="detailModalDescription"></p>
                </div>
            </div>
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b">
                <button type="button" data-modal-toggle="detailModal" class="text-white bg-[#4D44B5] hover:bg-[#3a32a1] focus:ring-4 focus:outline-none focus:ring-[#4D44B5] font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Fermer
                </button>
            </div>
        </div>
    </div>
</div>

    </main>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.6/dist/flowbite.min.js"></script>
<script>
    function showCourseDetails(title, description, imageUrl) {
        $('#detailModalTitle').text(title);
        $('#detailModalDescription').text(description);
        $('#detailModalImage').attr('src', imageUrl || '{{ asset('images/default-course.jpg') }}');
    }

    $(document).ready(function() {
        $('[data-modal-toggle]').click(function() {
            const target = $(this).attr('data-modal-target');
            $(target).toggleClass('hidden');
        });

        // Animation des cartes
        $('.grid > div').each(function(index) {
            $(this).css({
                'opacity': '0',
                'transform': 'translateY(20px)',
                'transition': 'all 0.3s ease-out'
            });
            
            setTimeout(() => {
                $(this).css({
                    'opacity': '1',
                    'transform': 'translateY(0)'
                });
            }, index * 100);
        });
    });
</script>
@endsection