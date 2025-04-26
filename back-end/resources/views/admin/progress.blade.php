@extends('layouts.admin')

@section('content')
<div class="flex-1 overflow-auto">
    <header class="bg-[#4D44B5] text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold">Progression des Candidats</h1>
                <p class="text-purple-100 mt-1">
                    {{ $title->name }} (Permis {{ $title->type_permis }})
                </p>
            </div>
            <a href="{{ route('admin.titles') }}" 
               class="bg-white text-[#4D44B5] px-4 py-2 rounded-lg font-medium hover:bg-gray-100 transition">
                <i class="fas fa-arrow-left mr-2"></i> Retour
            </a>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-xl shadow overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">Détail de la progression</h2>
                <span class="text-sm text-gray-500">
                    {{ $totalCourses }} cours au total
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Candidat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cours complétés</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progression</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dernière activité</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($candidates as $candidate)
                        @php
                            $progress = $title->getProgressForUser($candidate->id);
                        @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
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
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{-- <span class="font-medium">{{ $progress['completed'] }}/{{ $progress['total'] }}</span> --}}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-[#4D44B5] h-2.5 rounded-full" style="width: {{ $progress['percentage'] }}%"></div>
                                </div>
                                <div class="text-xs text-gray-500 mt-1">{{ $progress['percentage'] }}% complété</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $candidate->courseViews->last()->created_at->format('d/m/Y H:i') ?? 'N/A' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                Aucun candidat n'a encore commencé ce cours
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