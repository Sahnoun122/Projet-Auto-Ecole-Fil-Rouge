@extends('layouts.admin')

@section('content')
<div class="flex-1 overflow-auto p-4 md:p-6">
    <header class="bg-[#4D44B5] text-white shadow-md rounded-lg mb-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                <div>
                    <h1 class="text-xl md:text-2xl font-bold">Détail des résultats du Quiz</h1>
                    <p class="text-sm text-blue-100 mt-1">
                        {{ $candidate->prenom }} {{ $candidate->nom }} - {{ $quiz->title }}
                    </p>
                </div>
                
                <a href="{{ route('moniteur.quiz', $candidate) }}" 
                   class="bg-white text-[#4D44B5] px-4 py-2 rounded-lg font-medium hover:bg-gray-100 hover:shadow-sm transition-all duration-300 flex items-center w-max">
                    <i class="fas fa-arrow-left mr-2"></i> Retour à la liste des quiz
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto">
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white rounded-xl shadow-md p-4 sm:p-6 border-t-4 border-[#4D44B5]">
                <div class="flex items-center mb-4">
                    <div class="h-12 w-12 rounded-full bg-purple-100 flex items-center justify-center text-[#4D44B5] font-bold text-xl mr-4">
                        {{ strtoupper(substr($candidate->prenom, 0, 1)) }}{{ strtoupper(substr($candidate->nom, 0, 1)) }}
                    </div>
                    <div>
                        <h3 class="font-bold text-lg">{{ $candidate->prenom }} {{ $candidate->nom }}</h3>
                        <p class="text-gray-600">{{ $candidate->email }}</p>
                    </div>
                </div>
                <div class="space-y-2">
                    <p class="text-sm"><span class="font-medium">Type permis:</span> {{ $candidate->type_permis }}</p>
                    <p class="text-sm"><span class="font-medium">Dernière tentative:</span> {{ $results['details'][0]['answered_at'] ?? 'N/A' }}</p>
                </div>
            </div>
            
        </div>

        
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="px-4 sm:px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Détail des questions</h3>
            </div>
            <div class="divide-y divide-gray-200 max-h-[500px] overflow-y-auto">
                @foreach($results['details'] as $index => $detail)
                <div class="p-4 hover:bg-gray-50 transition">
                    <div class="flex items-start">
                        <span class="flex-shrink-0 flex items-center justify-center h-6 w-6 rounded-full 
                                  {{ $detail['is_correct'] ? 'bg-green-100 text-green-800' : ($detail['answered'] ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }} mr-4 text-xs">
                            {{ $index + 1 }}
                        </span>
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-800 mb-2">{{ $detail['question_text'] }}</h4>
                            
                            @if($detail['answered'])
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                                <div class="{{ $detail['is_correct'] ? 'bg-green-50' : 'bg-red-50' }} p-3 rounded-lg">
                                    <p class="text-xs font-medium text-gray-600 mb-1">Réponse du candidat</p>
                                    <p class="{{ $detail['is_correct'] ? 'text-green-800' : 'text-red-800' }} font-medium">
                                        {{ $detail['user_answer'] }}
                                    </p>
                                </div>
                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <p class="text-xs font-medium text-gray-600 mb-1">Bonne réponse</p>
                                    <p class="text-gray-800 font-medium">{{ $detail['correct_answer'] }}</p>
                                </div>
                            </div>
                            @else
                            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-3 mb-3">
                                <p class="text-yellow-700 flex items-center text-xs">
                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                    Non répondu
                                </p>
                            </div>
                            @endif
                            
                            <div class="flex flex-wrap items-center text-xs gap-3">
                                @if($detail['answered'])
                                    @if($detail['is_correct'])
                                        <span class="inline-flex items-center text-green-600">
                                            <i class="fas fa-check-circle mr-1"></i> Correct
                                        </span>
                                    @else
                                        <span class="inline-flex items-center text-red-600">
                                            <i class="fas fa-times-circle mr-1"></i> Incorrect
                                        </span>
                                    @endif
                                @else
                                    <span class="inline-flex items-center text-gray-600">
                                        <i class="fas fa-question-circle mr-1"></i> Non répondu
                                    </span>
                                @endif
                                <span class="text-gray-500">
                                    <i class="fas fa-clock mr-1"></i>
                                    {{ $detail['answered_at'] ?? 'N/A' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </main>
</div>
@endsection
