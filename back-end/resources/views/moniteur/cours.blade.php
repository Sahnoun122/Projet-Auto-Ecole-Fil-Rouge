@extends('layouts.moniteur')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center mb-6">
        <h1 class="text-2xl font-bold">Progression théorique - {{ $candidat->prenom }} {{ $candidat->nom }}</h1>
        <a href="{{ route('moniteur.progression', $candidat) }}" class="ml-auto text-blue-500 hover:text-blue-700">
            <i class="fas fa-arrow-left mr-1"></i> Retour
        </a>
    </div>

    @foreach($titles as $title)
    <div class="bg-white rounded-lg shadow-md mb-6 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b flex items-center">
            <h2 class="text-xl font-semibold">{{ $title->name }}</h2>
            <span class="ml-auto bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                {{ $title->courses_count }} cours
            </span>
        </div>

        <div class="divide-y divide-gray-200">
            @foreach($title->courses as $course)
            <div class="px-6 py-4 hover:bg-gray-50">
                <div class="flex items-center">
                    <div class="flex-1">
                        <h3 class="font-medium">{{ $course->title }}</h3>
                        <p class="text-sm text-gray-600 mt-1">{{ Str::limit($course->description, 100) }}</p>
                    </div>
                    <div class="ml-4">
                        @if($course->viewed > 0)
                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">
                                <i class="fas fa-check-circle mr-1"></i> Complété
                            </span>
                        @else
                            <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs">
                                <i class="fas fa-times-circle mr-1"></i> Non complété
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="px-6 py-3 bg-gray-50 border-t">
            <div class="flex items-center">
                <span class="text-sm text-gray-600">Progression globale</span>
                <span class="ml-auto font-medium">
                    {{ $title->courses->sum('viewed') }} / {{ $title->courses_count }}
                </span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                <div class="bg-blue-500 h-2 rounded-full" 
                     style="width: {{ $title->courses_count > 0 ? round(($title->courses->sum('viewed') / $title->courses_count) * 100) : 0 }}%"></div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection