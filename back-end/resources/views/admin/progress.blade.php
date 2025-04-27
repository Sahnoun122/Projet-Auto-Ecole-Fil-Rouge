@extends('layouts.admin')

@section('content')
<div class="flex-1 overflow-auto">
    <header class="bg-[#4D44B5] text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold">Progression - {{ $title->name }}</h1>
                    <p class="text-sm text-blue-100 mt-1">Permis {{ $title->type_permis }}</p>
                </div>
                <a href="{{ route('admin.titles', ['tab' => 'progress']) }}" 
                   class="bg-white text-[#4D44B5] px-4 py-2 rounded-lg font-medium hover:bg-gray-100 transition">
                    <i class="fas fa-arrow-left mr-2"></i> Retour
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-purple-50 p-4 rounded-lg">
                    <h3 class="text-sm text-purple-600 font-medium">Total Candidats</h3>
                    <p class="text-2xl font-bold text-purple-800 mt-2">{{ $candidates->total() }}</p>
                </div>
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h3 class="text-sm text-blue-600 font-medium">Total Cours</h3>
                    <p class="text-2xl font-bold text-blue-800 mt-2">{{ $totalCourses }}</p>
                </div>
                <div class="bg-green-50 p-4 rounded-lg">
                    <h3 class="text-sm text-green-600 font-medium">Progression Moyenne</h3>
                    <p class="text-2xl font-bold text-green-800 mt-2">
                        @php
                            $avgProgress = 0;
                            if($candidates->count() > 0) {
                                $totalProgress = 0;
                                foreach($candidates as $candidate) {
                                    $totalProgress += $candidate->total_views;
                                }
                                $maxViews = $totalCourses * $candidates->total();
                                $avgProgress = $maxViews ? round(($totalProgress / $maxViews) * 100) : 0;
                            }
                        @endphp
                        {{ $avgProgress }}%
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">Candidats</h2>
                <form action="{{ route('admin.progress', $title) }}" method="GET" class="flex items-center">
                    <div class="relative">
                        <input type="text" name="search" placeholder="Rechercher un candidat..." 
                               value="{{ $search }}"
                               class="w-64 pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]">
                        <i class="fas fa-search absolute left-3 top-2.5 text-gray-400"></i>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Candidat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cours Consultés</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progression</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dernière Activité</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($candidates as $candidate)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 flex-shrink-0">
                                        <div class="h-10 w-10 rounded-full bg-[#4D44B5] flex items-center justify-center text-white font-medium">
                                            {{ strtoupper(substr($candidate->prenom, 0, 1)) }}{{ strtoupper(substr($candidate->nom, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $candidate->prenom }} {{ $candidate->nom }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            ID: {{ $candidate->id }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $candidate->email }}</div>
                                <div class="text-sm text-gray-500">{{ $candidate->telephone }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ $candidate->total_views }} sur {{ $totalCourses }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    @php
                                        $percentage = $totalCourses ? round(($candidate->total_views / $totalCourses) * 100) : 0;
                                    @endphp
                                    <div class="bg-[#4D44B5] h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                                <div class="text-xs text-gray-500 mt-1">{{ $percentage }}% complété</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $lastActivity = $candidate->courseViews()
                                        ->whereHas('course', fn($q) => $q->where('title_id', $title->id))
                                        ->latest()
                                        ->first();
                                @endphp
                                <div class="text-sm text-gray-900">
                                    {{ $lastActivity ? $lastActivity->created_at->format('d/m/Y H:i') : 'Jamais' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.titles.candidate-progress', [$title, $candidate]) }}" 
                                   class="text-[#4D44B5] hover:text-[#3a32a1]">
                                    <i class="fas fa-eye mr-1"></i> Détails
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-gray-200">
                {{ $candidates->links() }}
            </div>
        </div>
    </main>
</div>
@endsection