@extends('layouts.moniteur')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center mb-6">
        <h1 class="text-2xl font-bold">Progression de {{ $candidat->prenom }} {{ $candidat->nom }}</h1>
        <a href="{{ route('moniteur.candidats') }}" class="ml-auto text-blue-500 hover:text-blue-700">
            <i class="fas fa-arrow-left mr-1"></i> Retour
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <a href="{{ route('moniteur.cours', $candidat) }}" 
           class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition cursor-pointer">
            <div class="flex items-center">
                <div class="bg-blue-100 p-3 rounded-full mr-4">
                    <i class="fas fa-book text-blue-500 text-xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-semibold">Progression théorique</h2>
                    <p class="text-gray-600 mt-1">Voir les cours étudiés</p>
                </div>
            </div>
        </a>

        <a href="{{ route('moniteur.quiz', $candidat) }}" 
           class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition cursor-pointer">
            <div class="flex items-center">
                <div class="bg-green-100 p-3 rounded-full mr-4">
                    <i class="fas fa-car text-green-500 text-xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-semibold">Progression pratique</h2>
                    <p class="text-gray-600 mt-1">Voir les résultats des quiz</p>
                </div>
            </div>
        </a>
    </div>
</div>
@endsection