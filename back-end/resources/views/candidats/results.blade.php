@extends('layouts.candidats')
@section('content')
        <div class="flex-1 overflow-auto">

         
            <div class="min-h-screen bg-gray-50">
                <div class="max-w-3xl mx-auto px-4 py-8">
                    <div class="bg-white rounded-xl shadow-md overflow-hidden">
                        <!-- En-tête -->
                        <div class="bg-[#4D44B5] px-6 py-8 text-white text-center">
                            <h1 class="text-3xl font-bold">Résultats du Quiz Permis</h1>
                            <div class="mt-4 text-4xl font-bold">
                                {{ $correctAnswers }}/40
                            </div>
                            <div class="mt-2">
                                @if($passed)
                                    <span class="inline-block px-4 py-1 bg-green-500 text-white rounded-full">
                                        Réussi !
                                    </span>
                                @else
                                    <span class="inline-block px-4 py-1 bg-red-500 text-white rounded-full">
                                        Échec (32/40 requis)
                                    </span>
                                @endif
                            </div>
                        </div>
            
                        <!-- Statistiques -->
                        <div class="p-6 grid grid-cols-2 gap-4">
                            <div class="bg-gray-100 p-4 rounded-lg text-center">
                                <div class="text-2xl font-bold text-[#4D44B5]">{{ $correctAnswers }}</div>
                                <div class="text-gray-600">Bonnes réponses</div>
                            </div>
                            <div class="bg-gray-100 p-4 rounded-lg text-center">
                                <div class="text-2xl font-bold text-[#4D44B5]">{{ 40 - $correctAnswers }}</div>
                                <div class="text-gray-600">Erreurs</div>
                            </div>
                        </div>
            
                        <!-- Détail des erreurs SEULEMENT -->
                        @if($wrongAnswers->count() > 0)
                        <div class="p-6 border-t">
                            <h2 class="text-xl font-bold text-gray-800 mb-4">Détail des erreurs</h2>
                            <div class="space-y-4">
                                @foreach($wrongAnswers as $question)
                                <div class="border-l-4 border-red-500 bg-red-50 p-4 rounded-r-lg">
                                    <div class="font-medium text-gray-800">{{ $question->question_text }}</div>
                                    <div class="mt-2">
                                        <p class="text-sm text-red-600">
                                            <span class="font-medium">Votre réponse:</span> 
                                            {{ $question->answers->first()->choice->choice_text }}
                                        </p>
                                        <p class="text-sm text-gray-600 mt-1">
                                            <span class="font-medium">Bonne réponse:</span> 
                                            {{ $question->choices->where('is_correct', true)->first()->choice_text }}
                                        </p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @else
                        <div class="p-6 text-center bg-green-50 text-green-700">
                            <div class="text-5xl mb-2">🎉</div>
                            <h3 class="text-xl font-bold">Parfait !</h3>
                            <p>Aucune erreur commise</p>
                        </div>
                        @endif
            
                        <!-- Boutons -->
                        <div class="p-6 border-t flex justify-center">
                            <a href="{{ route('candidats.quizzes') }}" 
                               class="px-6 py-2 bg-[#4D44B5] hover:bg-[#3a32a1] text-white rounded-lg">
                                Retour aux quiz
                            </a>
                        </div>
                    </div>
                </div>
            </div>
    
    <script>

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
        
 


    </script>
@endsection