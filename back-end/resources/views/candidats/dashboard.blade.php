@extends('layouts.candidats')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 bg-gray-50 min-h-screen">

    <header class="bg-[#4D44B5] text-white shadow-lg rounded-2xl mb-8 animate__animated animate__fadeIn">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <h1 class="text-3xl font-bold text-center md:text-left tracking-tight">Tableau de Bord Candidat</h1>
            <p class="mt-2 text-sm text-indigo-100 text-center md:text-left">Bienvenue, {{ $candidat->prenom }} ! Suivez vos progrès et accédez à vos ressources.</p>
        </div>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        <div class="lg:col-span-2 space-y-6">

            <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden transform hover:-translate-y-1 transition-all duration-300 animate__animated animate__fadeInUp">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-xl font-semibold text-gray-800">Résumé de vos Progrès (Cours Théoriques)</h2>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm font-medium text-gray-600">Progression</span>
                        <span class="text-sm font-semibold text-indigo-600">{{ $progressPercentage }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4">
                        <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ $progressPercentage }}%"></div>
                    </div>
                    <div class="flex justify-between text-sm text-gray-500">
                        <span>Cours complétés: {{ $totalCourses - $remainingCourses }} / {{ $totalCourses }}</span>
                        <span>Cours restants: {{ $remainingCourses }}</span>
                    </div>
                    <div class="mt-4 text-center">
                        <a href="{{ route('candidats.titres') }}" class="inline-block px-4 py-2 bg-indigo-500 text-white text-sm font-medium rounded-md hover:bg-indigo-600 transition duration-150 ease-in-out">Voir mes cours</a>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden animate__animated animate__fadeInUp">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h2 class="text-xl font-semibold text-gray-800">Accès Rapide aux Quizzes</h2>
                    <a href="{{ route('candidats.quizzes') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium inline-flex items-center" title="Voir tous les quizzes">
                        Voir tout
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </a>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($quizzes as $quiz)
                        <div class="p-4 hover:bg-gray-50 transition-colors duration-200 flex justify-between items-center">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $quiz->title }}</p>
                                <p class="text-xs text-gray-500">{{ $quiz->questions->count() }} questions</p>
                            </div>
                            <a href="{{ route('candidats.prepare', $quiz->id) }}" class="px-3 py-1 bg-green-500 text-white text-xs font-medium rounded-full hover:bg-green-600 transition duration-150 ease-in-out">Commencer</a>
                        </div>
                    @empty
                        <div class="p-5 text-center text-gray-500">
                            Aucun quiz disponible pour le moment.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

        <div class="lg:col-span-1 space-y-6">

            <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden animate__animated animate__fadeInRight">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-blue-50">
                    <h2 class="text-lg font-semibold text-blue-800">Notifications Récentes</h2>
                    <a href="{{ route('notifications') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium inline-flex items-center" title="Voir toutes les notifications">
                        Voir tout
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </a>
                </div>
                <div class="divide-y divide-gray-100 max-h-96 overflow-y-auto">
                    @forelse($notifications as $notification)
                        <div class="p-4 hover:bg-gray-50 transition-colors duration-200">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path></svg>
                                </div>
                                <div class="ml-3 flex-1">
                                    <p class="text-sm text-gray-700">{{ $notification->data['message'] ?? 'Notification sans message.' }}</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                    @if(isset($notification->data['action_url']))
                                        <a href="{{ $notification->data['action_url'] }}" class="text-xs text-blue-500 hover:underline mt-1 inline-block">Voir détails</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-5 text-center text-gray-500">
                            Aucune nouvelle notification.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
@endpush

@endsection