@extends('layouts.moniteur')
@section('title', 'Progression de ' . $candidat->prenom . ' ' . $candidat->nom)

@section('content')
<div class="flex-1 overflow-auto p-4 md:p-6">
    <header class="bg-[#4D44B5] text-white shadow-md rounded-lg mb-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col md:flex-row justify-between items-center">
            <h1 class="text-2xl font-bold mb-2 md:mb-0">Progression de {{ $candidat->prenom }} {{ $candidat->nom }}</h1>
            <a href="{{ route('moniteur.candidats') }}" class="bg-white text-[#4D44B5] px-4 py-2 rounded-lg font-medium hover:bg-gray-100 transition flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Retour aux Candidats
            </a>
        </div>
    </header>

    <main class="max-w-7xl mx-auto">
        <div class="bg-white rounded-xl shadow overflow-hidden p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Consulter la progression</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <a href="{{ route('moniteur.cours', $candidat->id) }}" 
                   class="bg-gray-50 rounded-lg shadow p-6 hover:shadow-md transition border border-gray-200 flex items-center space-x-4">
                    <div class="bg-blue-100 p-3 rounded-full">
                        <i class="fas fa-book text-blue-500 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700">Progression théorique</h3>
                        <p class="text-gray-600 mt-1 text-sm">Voir les cours théoriques étudiés</p>
                    </div>
                </a>

                <a href="{{ route('moniteur.quiz', $candidat->id) }}" 
                   class="bg-gray-50 rounded-lg shadow p-6 hover:shadow-md transition border border-gray-200 flex items-center space-x-4">
                    <div class="bg-green-100 p-3 rounded-full">
                        <i class="fas fa-tasks text-green-500 text-xl"></i> {{-- Changed icon for variety --}}
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700">Résultats des Quiz</h3>
                        <p class="text-gray-600 mt-1 text-sm">Voir les résultats des quiz et examens blancs</p>
                    </div>
                </a>
                
                {{-- Potentiellement ajouter une carte pour la progression pratique (leçons de conduite) si applicable --}}
                {{-- <a href="#" 
                   class="bg-gray-50 rounded-lg shadow p-6 hover:shadow-md transition border border-gray-200 flex items-center space-x-4">
                    <div class="bg-purple-100 p-3 rounded-full">
                        <i class="fas fa-car text-purple-500 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700">Progression pratique</h3>
                        <p class="text-gray-600 mt-1 text-sm">Suivre les leçons de conduite</p>
                    </div>
                </a> --}}
            </div>
        </div>
    </main>
</div>
@endsection