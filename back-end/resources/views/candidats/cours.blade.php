@extends('layouts.candidats')

@section('content')
<div class="container mx-auto ">
    <div class="bg-[#4D44B5] text-white  p-6 mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold">{{ $title->name }}</h1>
                <p class="mt-2">Cours pour le permis {{ $typePermis }}</p>
            </div>
            <a href="{{ url()->previous() }}" class="text-white hover:text-gray-200">
                <i class="fas fa-arrow-left mr-2"></i> Retour
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6" id="coursesContainer">
        @forelse($courses as $course)
        <div class="border rounded-lg p-4 hover:shadow-md transition">
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
            <p class="text-sm text-gray-600 mb-3">{{ Str::limit($course->description, 100) }}</p>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-500">{{ $course->duration }} minutes</span>
                <a href="{{ route('candidats.titres.cours', $course) }}" 
                   class="bg-[#4D44B5] hover:bg-[#3a32a1] text-white px-3 py-1 rounded text-sm">
                   Voir le cours
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-10">
            <div class="bg-white rounded-xl shadow-md p-8">
                <i class="fas fa-book-open text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-700">
                    Aucun cours disponible dans cette catégorie
                </h3>
            </div>
        </div>
        @endforelse
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('#coursesContainer > div');
        cards.forEach((card, index) => {
            setTimeout(() => {
                card.classList.add('opacity-0');
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'all 0.3s ease-out';
                
                setTimeout(() => {
                    card.classList.remove('opacity-0');
                    card.style.transform = 'translateY(0)';
                }, 50);
            }, index * 100);
        });
    });
</script>
@endsection