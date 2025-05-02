@extends('layouts.moniteur')

@section('content')
<div class="flex-1 overflow-auto p-4 md:p-6">
    {{-- Header --}}
    <header class="bg-[#4D44B5] text-white shadow-md rounded-lg mb-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0 text-center md:text-left">
                    <h1 class="text-2xl font-bold">Progression Théorique</h1>
                    <p class="text-sm text-blue-100 mt-1">{{ $candidat->prenom }} {{ $candidat->nom }}</p>
                </div>
                <a href="{{ route('moniteur.progression', $candidat) }}"
                   class="bg-white text-[#4D44B5] px-4 py-2 rounded-lg font-medium hover:bg-gray-100 transition flex items-center w-full md:w-auto justify-center">
                    <i class="fas fa-arrow-left mr-2"></i> Retour
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto">
        @php
            $totalCoursesOverall = 0;
            $completedCoursesOverall = 0;
            foreach($titles as $title) {
                $totalCoursesOverall += $title->courses_count;
                $completedCoursesOverall += $title->courses->sum('viewed');
            }
            $overallProgressPercentage = $totalCoursesOverall > 0 ? round(($completedCoursesOverall / $totalCoursesOverall) * 100) : 0;
        @endphp
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-blue-50 p-4 rounded-lg text-center md:text-left">
                    <h3 class="text-sm text-blue-600 font-medium">Total Cours Théoriques</h3>
                    <p class="text-2xl font-bold text-blue-800 mt-2">{{ $totalCoursesOverall }}</p>
                </div>
                <div class="bg-green-50 p-4 rounded-lg text-center md:text-left">
                    <h3 class="text-sm text-green-600 font-medium">Cours Complétés</h3>
                    <p class="text-2xl font-bold text-green-800 mt-2">{{ $completedCoursesOverall }}</p>
                </div>
                <div class="bg-purple-50 p-4 rounded-lg text-center md:text-left">
                    <h3 class="text-sm text-purple-600 font-medium">Progression Globale</h3>
                    <p class="text-2xl font-bold text-purple-800 mt-2">{{ $overallProgressPercentage }}%</p>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                        <div class="bg-[#4D44B5] h-2.5 rounded-full" style="width: {{ $overallProgressPercentage }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        @foreach($titles as $title)
        <div class="bg-white rounded-xl shadow-md mb-6 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b flex flex-col md:flex-row justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800 mb-2 md:mb-0">{{ $title->name }}</h2>
                <div class="w-full md:w-1/3">
                     <div class="flex items-center justify-between mb-1">
                        <span class="text-sm font-medium text-gray-700">Progression Titre</span>
                        <span class="text-sm font-medium text-[#4D44B5]">
                            {{ $title->courses->sum('viewed') }} / {{ $title->courses_count }}
                        </span>
                    </div>
                    @php
                        $titleProgressPercentage = $title->courses_count > 0 ? round(($title->courses->sum('viewed') / $title->courses_count) * 100) : 0;
                    @endphp
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-[#4D44B5] h-2.5 rounded-full" style="width: {{ $titleProgressPercentage }}%"></div>
                    </div>
                     <div class="text-xs text-gray-500 mt-1 text-right">{{ $titleProgressPercentage }}%</div>
                </div>
            </div>

            <div class="divide-y divide-gray-200">
                @forelse($title->courses as $course)
                <div class="px-6 py-4 hover:bg-gray-50">
                    <div class="flex items-center">
                        <div class="flex-1">
                            <h3 class="font-medium text-gray-900">{{ $course->title }}</h3>
                        </div>
                        <div class="ml-4 flex-shrink-0">
                            @if($course->viewed > 0)
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i> Complété
                                </span>
                            @else
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    <i class="far fa-circle mr-1"></i> Non complété
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                 <div class="px-6 py-4 text-center text-gray-500">
                    Aucun cours trouvé pour ce titre.
                </div>
                @endforelse
            </div>
        </div>
        @endforeach
    </main>
</div>
@endsection