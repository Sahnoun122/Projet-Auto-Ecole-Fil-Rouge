@extends('layouts.candidats')
@section('content')
        <div class="flex-1 overflow-auto">
            <div class="flex-1 overflow-auto">
                <div class="min-h-screen">
                    <header class="bg-[#4D44B5] text-white shadow-md">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                            <h1 class="text-3xl font-bold">Quiz Permis</h1>
                            <p class="mt-2 text-lg text-purple-100">
                                Entraînez-vous pour votre permis {{ $typePermis }}
                            </p>
                        </div>
                    </header>
            
                    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                        <div class="mb-8">
                            <form action="{{ route('candidats.quizzes') }}" method="GET" class="max-w-md mx-auto">
                                <div class="relative">
                                    <input 
                                        type="text" 
                                        name="search" 
                                        placeholder="Rechercher un quiz..." 
                                        value="{{ request('search') }}"
                                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#4D44B5] focus:border-transparent"
                                    >
                                    <i class="fas fa-search absolute left-3 top-3.5 text-gray-400"></i>
                                    @if(request('search'))
                                    <a 
                                        href="{{ route('candidats.quizzes') }}" 
                                        class="absolute right-3 top-3.5 text-gray-400 hover:text-gray-600"
                                    >
                                        <i class="fas fa-times"></i>
                                    </a>
                                    @endif
                                </div>
                            </form>
                        </div>
            
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @forelse($quizzes as $quiz)
                            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 hover:shadow-lg transition-all duration-300">
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
                                        class="w-full block text-center bg-[#4D44B5] hover:bg-[#3a32a1] text-white font-medium py-2 px-4 rounded-lg transition">
                                         Commencer le quiz
                                     </a>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-span-3 text-center py-10">
                                <div class="bg-white rounded-xl shadow-md p-8">
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
                            </div>
                            @endforelse
                        </div>
                    </main>
                </div>
            </div>
            
            <script>
                $(document).ready(function() {
                    function animateProgressBars() {
                        setTimeout(() => {
                            const progressBars = document.querySelectorAll('.progress-bar');
                            progressBars.forEach(bar => {
                                const width = bar.style.width;
                                bar.style.width = '0';
                                setTimeout(() => {
                                    bar.style.width = width;
                                }, 300);
                            });
                        }, 500);
                    }
                
                    animateProgressBars();
                });
        


 document.addEventListener('DOMContentLoaded', function() {
    setTimeout(() => {
      const progressBars = document.querySelectorAll('.progress-bar');
      progressBars.forEach(bar => {
        const width = bar.style.width;
        bar.style.width = '0';
        setTimeout(() => {
          bar.style.width = width;
        }, 300);
      });
    }, 500);
    
    const badge = document.querySelector('.pulse');
    if (badge) {
      setInterval(() => {
        badge.classList.add('animate-pulse');
        setTimeout(() => {
          badge.classList.remove('animate-pulse');
        }, 1000);
      }, 2000);
    }
  });
        
  document.addEventListener("DOMContentLoaded", function () {
    function toggleSection(headerId, listId, arrowId) {
      const header = document.getElementById(headerId);
      const list = document.getElementById(listId);
      const arrow = document.getElementById(arrowId);
  
      let isOpen = list.style.maxHeight !== "0px";
  
      header.addEventListener("click", function () {
        if (isOpen) {
          list.style.maxHeight = "0";
          arrow.style.transform = "rotate(0deg)";
        } else {
          list.style.maxHeight = `${list.scrollHeight}px`;
          arrow.style.transform = "rotate(90deg)";
        }
        isOpen = !isOpen;
      });
    }
  
    toggleSection("cours-theorique-header", "cours-theorique-list", "cours-theorique-arrow");
    toggleSection("cours-pratique-header", "cours-pratique-list", "cours-pratique-arrow");
    toggleSection("examen-header", "examen-list", "examen-arrow");
    toggleSection("moniteurs-header", "moniteurs-list", "moniteurs-arrow");
    toggleSection("caisse-header", "caisse-list", "caisse-arrow");
  });

async function logout() {
    try {
        const response = await fetch('/api/logout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('token')}`, 
            },
        });

        const data = await response.json();

        if (response.ok) {
            localStorage.removeItem('token');
            localStorage.removeItem('role');
            alert(data.message);
            window.location.href = '/connecter'; 
        } else {
            alert('Échec de la déconnexion : ' + data.message); 
        }
    } catch (error) {
        console.error('Erreur lors de la déconnexion:', error);
        alert('Une erreur est survenue. Veuillez réessayer.');
    }
}

document.getElementById('logoutButton').addEventListener('click', logout);
    </script>

@endsection
