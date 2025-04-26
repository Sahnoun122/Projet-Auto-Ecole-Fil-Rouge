@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Résultats du Quiz: {{ $quiz->title }}</h1>
            <a href="{{ route('admin.quizzes.index') }}" class="btn btn-primary">
                <i class="fas fa-arrow-left mr-2"></i> Retour
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="py-3 px-4 text-left">Candidat</th>
                        <th class="py-3 px-4 text-left">Score</th>
                        <th class="py-3 px-4 text-left">Statut</th>
                        <th class="py-3 px-4 text-left">Date</th>
                        <th class="py-3 px-4 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($candidates as $candidate)
                    <tr class="border-t hover:bg-gray-50">
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
                            <a href="{{ route('admin.quizzes.candidate-results', ['quiz' => $quiz->id, 'candidate' => $candidate->id]) }}" 
                               class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-eye mr-1"></i> Détails
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $candidates->links() }}
        </div>
    </div>
</div>
@endsection