@extends('layouts.admin')

@section('content')
<div class="flex-1 overflow-auto p-4 md:p-6">
    <header class="bg-[#4D44B5] text-white shadow-md rounded-lg mb-6">
        <div class="px-4 sm:px-6 py-5">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                <div>
                    <h1 class="text-xl md:text-2xl font-bold">Résultats du Quiz: {{ $quiz->title }}</h1>
                    <p class="text-sm text-blue-100 mt-1 flex items-center">
                        <i class="fas fa-list-check mr-2"></i>{{ $candidates->count() }} candidats ont passé ce quiz
                    </p>
                </div>
                <a href="{{ route('admin.quizzes') }}"
                   class="bg-white text-[#4D44B5] px-4 py-2 rounded-lg font-medium hover:bg-gray-100 hover:shadow-sm transition-all duration-300 flex items-center w-max">
                    <i class="fas fa-arrow-left mr-2"></i> Retour
                </a>
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto bg-white rounded-lg shadow-md">
        <div class="p-4 sm:p-6">
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Candidat</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Score</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($candidates as $candidate)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-4">
                                <div class="flex items-center">
                                    <img src="{{ $candidate->getProfilePhotoUrlAttribute() }}"
                                         alt="Photo profil"
                                         class="w-10 h-10 rounded-full mr-3">
                                    <div>
                                        <p class="font-medium">{{ $candidate->prenom }} {{ $candidate->nom }}</p>
                                        <p class="text-sm text-gray-600">{{ $candidate->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                {{ $candidate->correct_answers }}/{{ $totalQuestions }}
                                <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                                    @php
                                        $percentage = ($candidate->correct_answers / $totalQuestions) * 100;
                                        $color = $percentage >= 80 ? 'bg-green-500' : 'bg-red-500';
                                    @endphp
                                    <div class="h-2 rounded-full {{ $color }}" style="width: {{ $percentage }}%"></div>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                @if($percentage >= 80)
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">
                                        Réussi
                                    </span>
                                @else
                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">
                                        Échoué
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-sm text-gray-600">
                                {{ $candidate->answers->first()->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="py-3 px-4">
                                <a href="{{ route('admin.candidate-results', ['quiz' => $quiz->id, 'candidate' => $candidate->id]) }}"
                                   class="text-[#4D44B5] hover:text-[#3b3494] font-medium">
                                    <i class="fas fa-eye mr-1"></i> Détails
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="md:hidden space-y-4">
                @foreach($candidates as $candidate)
                    @php
                        $percentage = ($candidate->correct_answers / $totalQuestions) * 100;
                        $color = $percentage >= 80 ? 'bg-green-500' : 'bg-red-500';
                        $statusBg = $percentage >= 80 ? 'bg-green-100' : 'bg-red-100';
                        $statusText = $percentage >= 80 ? 'text-green-800' : 'text-red-800';
                        $status = $percentage >= 80 ? 'Réussi' : 'Échoué';
                    @endphp
                    <div class="bg-white border rounded-lg shadow-sm overflow-hidden">
                        <div class="p-4">
                            <div class="flex items-center space-x-3">
                                <img src="{{ $candidate->getProfilePhotoUrlAttribute() }}"
                                     alt="Photo profil"
                                     class="w-12 h-12 rounded-full">
                                <div>
                                    <p class="font-medium">{{ $candidate->prenom }} {{ $candidate->nom }}</p>
                                    <p class="text-sm text-gray-600">{{ $candidate->email }}</p>
                                </div>
                            </div>
                            
                            <div class="mt-4 grid grid-cols-2 gap-3">
                                <div>
                                    <p class="text-sm text-gray-500">Score</p>
                                    <p class="font-medium">{{ $candidate->correct_answers }}/{{ $totalQuestions }}</p>
                                    <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                                        <div class="h-2 rounded-full {{ $color }}" style="width: {{ $percentage }}%"></div>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Statut</p>
                                    <span class="mt-1 px-2 py-1 {{ $statusBg }} {{ $statusText }} rounded-full text-xs inline-block">
                                        {{ $status }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="mt-3 pt-3 border-t border-gray-100 flex justify-between items-center">
                                <div class="text-xs text-gray-500">
                                    {{ $candidate->answers->first()->created_at->format('d/m/Y H:i') }}
                                </div>
                                <a href="{{ route('admin.candidate-results', ['quiz' => $quiz->id, 'candidate' => $candidate->id]) }}"
                                   class="text-[#4D44B5] hover:text-[#3b3494] text-sm font-medium">
                                    <i class="fas fa-eye mr-1"></i> Détails
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $candidates->links() }}
            </div>
        </div>
    </div>
</div>
@endsection