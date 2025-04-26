@extends('layouts.admin')

@section('content')
<div class="flex-1 overflow-auto">
    <header class="bg-[#4D44B5] text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold">Résultats du Quiz</h1>
                <p class="text-purple-100 mt-1">
                    {{ $quiz->title }} ({{ $quiz->type_permis }})
                </p>
            </div>
            <a href="{{ route('admin.quizzes.index') }}" 
               class="bg-white text-[#4D44B5] px-4 py-2 rounded-lg font-medium hover:bg-gray-100 transition">
                <i class="fas fa-arrow-left mr-2"></i> Retour
            </a>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-xl shadow overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">Candidats ayant passé le quiz</h2>
                <span class="text-sm text-gray-500">
                    {{ $candidates->total() }} candidat(s)
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Candidat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Score</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($candidates as $candidate)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center text-[#4D44B5] font-bold">
                                        {{ strtoupper(substr($candidate->name, 0, 1)) }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $candidate->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $candidate->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $candidate->correct_answers }}/{{ $quiz->questions_count }}
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-1.5 mt-1">
                                    <div class="bg-{{ ($candidate->correct_answers / $quiz->questions_count) >= 0.8 ? 'green' : 'red' }}-500 h-1.5 rounded-full" 
                                         style="width: {{ ($candidate->correct_answers / $quiz->questions_count) * 100 }}%"></div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                      {{ ($candidate->correct_answers / $quiz->questions_count) >= 0.8 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ($candidate->correct_answers / $quiz->questions_count) >= 0.8 ? 'Réussi' : 'Échoué' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $candidate->answers->first()->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.quizzes.candidate-results', ['quiz' => $quiz->id, 'candidate' => $candidate->id]) }}" 
                                   class="text-[#4D44B5] hover:text-[#3a32a1]">
                                    <i class="fas fa-eye mr-1"></i> Détails
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                Aucun candidat n'a encore passé ce quiz
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($candidates->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $candidates->links() }}
            </div>
            @endif
        </div>
    </main>
</div>
@endsection