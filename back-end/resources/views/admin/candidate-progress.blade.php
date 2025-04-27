@extends('layouts.admin')

@section('content')
<div class="flex-1 overflow-auto">
    <header class="bg-[#4D44B5] text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold">{{ $candidate->prenom }} {{ $candidate->nom }}</h1>
                    <p class="text-sm text-blue-100 mt-1">Progression - {{ $title->name }}</p>
                </div>
                <a href="{{ route('admin.progress', $title) }}" 
                   class="bg-white text-[#4D44B5] px-4 py-2 rounded-lg font-medium hover:bg-gray-100 transition">
                    <i class="fas fa-arrow-left mr-2"></i> Retour
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Informations du candidat</h2>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="text-sm font-medium text-gray-900">{{ $candidate->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Téléphone</p>
                        <p class="text-sm font-medium text-gray-900">{{ $candidate->telephone ?? 'Non renseigné' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Type de permis</p>
                        <p class="text-sm font-medium text-gray-900">Permis {{ $candidate->type_permis }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Dernière activité</p>
                        <p class="text-sm font-medium text-gray-900">
                            {{ $lastActivity ? $lastActivity->created_at->format('d/m/Y H:i') : 'Aucune' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 lg:col-span-2">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Statistiques de progression</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-green-50 p-4 rounded-lg">
                        <h3 class="text-sm text-green-600 font-medium">Cours complétés</h3>
                        <p class="text-2xl font-bold text-green-800 mt-2">{{ $progress['viewed'] }}</p>
                    </div>
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h3 class="text-sm text-blue-600 font-medium">Cours restants</h3>
                        <p class="text-2xl font-bold text-blue-800 mt-2">{{ $progress['total'] - $progress['viewed'] }}</p>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-lg">
                        <h3 class="text-sm text-purple-600 font-medium">Progression</h3>
                        <p class="text-2xl font-bold text-purple-800 mt-2">{{ $progress['percentage'] }}%</p>
                    </div>
                </div>

                <div class="mt-6">
                    <div class="w-full bg-gray-200 rounded-full h-4">
                        <div class="bg-[#4D44B5] h-4 rounded-full" style="width: {{ $progress['percentage'] }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Détail des cours</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cours</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date de consultation</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Temps passé</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($courses as $course)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $course->title }}</div>
                                <div class="text-sm text-gray-500">{{ Str::limit($course->description, 60) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($course->views->count() > 0)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Complété
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Non consulté
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ $course->views->count() > 0 ? $course->views->first()->created_at->format('d/m/Y H:i') : '-' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ $course->views->count() > 0 ? $course->views->first()->duration ?? '-' : '-' }}
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
@endsection