@extends('layouts.moniteur')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center mb-6">
        <h1 class="text-2xl font-bold">Progression pratique - {{ $candidat->prenom }} {{ $candidat->nom }}</h1>
        <a href="{{ route('moniteur.progression', $candidat) }}" class="ml-auto text-blue-500 hover:text-blue-700">
            <i class="fas fa-arrow-left mr-1"></i> Retour
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quiz</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Score</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($quizzes as $quiz)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="font-medium">{{ $quiz->title }}</div>
                        <div class="text-sm text-gray-600">{{ $quiz->description }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="font-bold {{ $quiz->passed ? 'text-green-600' : 'text-red-600' }}">
                            {{ $quiz->score }}/{{ $quiz->total_questions }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if($quiz->passed)
                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">
                                Réussi
                            </span>
                        @else
                            <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">
                                Échoué
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($quiz->score > 0)
                            <a href="{{ route('admin.candidate-results', ['quiz' => $quiz, 'candidate' => $candidat]) }}" 
                               class="text-blue-500 hover:text-blue-700">
                                Détails
                            </a>
                        @else
                            <span class="text-gray-400">Non tenté</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                        Aucun quiz disponible
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection