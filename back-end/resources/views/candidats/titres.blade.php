@extends('layouts.candidats')

@section('content')
<div class="flex-1 overflow-auto">
    <div class="min-h-screen">
        <header class="bg-[#4D44B5] text-white shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <h1 class="text-3xl font-bold">Cours Permis</h1>
                <p class="mt-2 text-lg text-purple-100">
                    Choisissez une catégorie pour votre permis {{ $typePermis }}
                </p>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="mb-8">
                <form action="{{ route('candidats.titres') }}" method="GET" class="max-w-md mx-auto">
                    <div class="relative">
                        <input 
                            type="text" 
                            name="search" 
                            placeholder="Rechercher une catégorie..." 
                            value="{{ $searchTerm ?? '' }}"
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#4D44B5] focus:border-transparent"
                        >
                        <i class="fas fa-search absolute left-3 top-3.5 text-gray-400"></i>
                        @if(!empty($searchTerm))
                        <a 
                            href="{{ route('candidats.titres') }}" 
                            class="absolute right-3 top-3.5 text-gray-400 hover:text-gray-600"
                            title="Effacer la recherche"
                        >
                            <i class="fas fa-times"></i>
                        </a>
                        @endif
                    </div>
                </form>
            </div>

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
                                  <a href="{{ route('candidats.titres.cours', $title) }}" class="block">
                                    <h3 class="text-xl font-bold text-gray-800">{{ $title->name }}</h3>                                     </a>
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
                            <a href="{{ route('candidats.titres.cours', $title) }}" 
                               class="w-full block text-center bg-[#4D44B5] hover:bg-[#3a32a1] text-white font-medium py-2 px-4 rounded-lg transition-colors duration-300">
                               Voir les cours <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-3 text-center py-10">
                    <div class="bg-white rounded-xl shadow-md p-8">
                        <i class="fas fa-book-open text-4xl text-gray-300 mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-700">
                            @if(!empty($searchTerm))
                                Aucune catégorie trouvée pour "{{ $searchTerm }}"
                            @else
                                Aucune catégorie disponible pour votre permis
                            @endif
                        </h3>
                        @if(!empty($searchTerm))
                        <a 
                            href="{{ route('candidats.titres') }}" 
                            class="mt-4 inline-block text-[#4D44B5] hover:text-[#3a32a1] font-medium"
                        >
                            <i class="fas fa-undo-alt mr-2"></i> Réinitialiser la recherche
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
        </main>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.transform');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.classList.add('shadow-lg', '-translate-y-1');
            this.classList.remove('shadow-md');
        });
        card.addEventListener('mouseleave', function() {
            this.classList.remove('shadow-lg', '-translate-y-1');
            this.classList.add('shadow-md');
        });
    });

    @if(!empty($searchTerm))
    document.querySelector('input[name="search"]').focus();
    @endif
});
</script>
@endsection