<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auto-école Sahnoun - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.10.3/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">


    <style>
        .hidden {
    display: none;
}
.flex {
    display: flex;
}
.fixed {
    position: fixed;
}
.inset-0 {
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
}
    </style>
</head>

<body class="bg-gray-100" x-data="{ sidebarOpen: true }">
    <div class="flex h-screen">
        <div :class="sidebarOpen ? 'w-64' : 'w-20'" class="bg-white shadow-lg transition-all duration-300 flex flex-col">
            <div class="p-4 flex justify-between items-center border-b">

                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                </button>
            </div>

            <div class="p-4 border-b flex justify-center">
                <div class="relative group">
                    <div
                        class="absolute inset-0 bg-primary rounded-full opacity-10 group-hover:opacity-20 transition-opacity">
                    </div>
                    <img src="/api/placeholder/60/60" alt="Auto-école"
                        class="h-16 w-16 object-contain rounded-full border-2 border-gray-200" />
                    <div class="absolute bottom-0 right-0 h-4 w-4 bg-green-500 rounded-full border-2 border-white">
                    </div>
                </div>
            </div>

            <div :class="sidebarOpen ? 'block' : 'hidden'" class="text-center py-2 text-sm font-medium text-gray-600">
                Auto-école S A H N O U N
            </div>
            <div class="flex-1 overflow-y-auto py-4">
                <nav>
                    <a href=" {{ route('admin.dashboard') }}"
                        class="sidebar-item flex items-center px-4 py-3 text-primary bg-indigo-50 border-l-4 border-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Tableau de bord</span>
                    </a>


                    <div>
                        <div id="candidats-header"
                            class="sidebar-item flex items-center px-4 py-3 text-gray-600 hover:text-primary transition-colors cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Candidats</span>
                            <svg id="candidats-arrow" class="ml-auto h-4 w-4 transition-transform" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                        <div id="candidats-list" class="pl-8 overflow-hidden transition-all duration-300 max-h-0">
                            <a href="#"
                                class="sidebar-item flex items-center px-4 py-2 text-gray-600 hover:text-primary transition-colors">
                                <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Ajouter Candidats</span>
                            </a>
                            <a href=" {{ route('admin.gestionCandidats') }} "
                                class="sidebar-item flex items-center px-4 py-2 text-gray-600 hover:text-primary transition-colors">
                                <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Liste des Candidats</span>
                            </a>
                        </div>
                    </div>

                    <div>
                        <div id="cours-theorique-header"
                            class="sidebar-item flex items-center px-4 py-3 text-gray-600 hover:text-primary transition-colors cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>

                            <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Cours Théorique</span>
                            <svg id="cours-theorique-arrow" class="ml-auto h-4 w-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                              </svg>                            </div>
                        <div id="cours-theorique-list" class="pl-8 overflow-hidden transition-all duration-300 max-h-0">
                            <a href="#"
                                class="sidebar-item flex items-center px-4 py-2 text-gray-600 hover:text-primary transition-colors">
                                <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Ajouter Cours Théorique</span>
                            </a>
                            <a href="#"
                                class="sidebar-item flex items-center px-4 py-2 text-gray-600 hover:text-primary transition-colors">
                                <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Liste des Cours Théorique</span>
                            </a>
                        </div>
                    </div>

                    <div>
                        <div id="cours-pratique-header"
                            class="sidebar-item flex items-center px-4 py-3 text-gray-600 hover:text-primary transition-colors cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Cours Pratique</span>
                            <svg id="cours-pratique-arrow" class="ml-auto h-4 w-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                              </svg>
                        </div>
                        <div id="cours-pratique-list"
                            class="pl-8 overflow-hidden transition-all duration-300 max-h-0">
                            <a href="{{ route('admin.AjouterQuiz') }} "
                                class="sidebar-item flex items-center px-4 py-2 text-gray-600 hover:text-primary transition-colors">
                                <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Ajouter Cours Pratique</span>
                            </a>
                            <a href="{{ route('admin.AjouterQuiz')}}"
                                class="sidebar-item flex items-center px-4 py-2 text-gray-600 hover:text-primary transition-colors">
                                <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Liste des Cours Pratique</span>
                            </a>
                        </div>
                    </div>

                    <div>
                        <div id="vehicule-header"
                            class="sidebar-item flex items-center px-4 py-3 text-gray-600 hover:text-primary transition-colors cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                            </svg>

                            <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Véhicule</span>
                            <svg id="vehicule-arrow" class="ml-auto h-4 w-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                              </svg>
                        </div>
                        <div id="vehicule-list" class="pl-8 overflow-hidden transition-all duration-300 max-h-0">
                            <a href="#"
                                class="sidebar-item flex items-center px-4 py-2 text-gray-600 hover:text-primary transition-colors">
                                <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Ajouter Véhicule</span>
                            </a>
                            <a href="#"
                                class="sidebar-item flex items-center px-4 py-2 text-gray-600 hover:text-primary transition-colors">
                                <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Liste des Véhicules</span>
                            </a>
                        </div>
                    </div>

                    <div>
                        <div id="examen-header"
                            class="sidebar-item flex items-center px-4 py-3 text-gray-600 hover:text-primary transition-colors cursor-pointer">

                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>

                            <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Examen</span>
                            <svg id="examen-arrow" class="ml-auto h-4 w-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                              </svg>
                        </div>
                        <div id="examen-list" class="pl-8 overflow-hidden transition-all duration-300 max-h-0">
                            <a href="#"
                                class="sidebar-item flex items-center px-4 py-2 text-gray-600 hover:text-primary transition-colors">
                                <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Ajouter Examen</span>
                            </a>
                            <a href="#"
                                class="sidebar-item flex items-center px-4 py-2 text-gray-600 hover:text-primary transition-colors">
                                <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Liste des Examens</span>
                            </a>
                        </div>


                    </div>

                    <div>
                        <div id="moniteurs-header"
                            class="sidebar-item flex items-center px-4 py-3 text-gray-600 hover:text-primary transition-colors cursor-pointer">

                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                            <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Moniteurs</span>
                            <svg id="moniteurs-arrow" class="ml-auto h-4 w-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                              </svg>

                        </div>
                        <div id="moniteurs-list" class="pl-8 overflow-hidden transition-all duration-300 max-h-0">
                            <a href="#"
                                class="sidebar-item flex items-center px-4 py-2 text-gray-600 hover:text-primary transition-colors">
                                <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Ajouter Moniteurs</span>
                            </a>
                            <a href="#"
                                class="sidebar-item flex items-center px-4 py-2 text-gray-600 hover:text-primary transition-colors">
                                <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Liste des Moniteurs</span>
                            </a>
                        </div>

                    </div>

                    <div>
                        <div id="caisse-header"
                            class="sidebar-item flex items-center px-4 py-3 text-gray-600 hover:text-primary transition-colors cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Caisse</span>
                            <svg id="caisse-arrow" class="ml-auto h-4 w-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                              </svg>
                        </div>

                        <div id="caisse-list" class="pl-8 overflow-hidden transition-all duration-300 max-h-0">
                            <a href="#"
                                class="sidebar-item flex items-center px-4 py-2 text-gray-600 hover:text-primary transition-colors">
                                <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Ajouter Caisse</span>
                            </a>
                            <a href="#"
                                class="sidebar-item flex items-center px-4 py-2 text-gray-600 hover:text-primary transition-colors">
                                <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Liste des Caisses</span>
                            </a>
                        </div>
                        <div id="logout-button" class="sidebar-item flex items-center px-4 py-3 text-gray-600 hover:text-primary transition-colors cursor-pointer" id="logoutButton">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H3" />
                            </svg>
                            <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Déconnexion</span>
                        </div>
                        
                    </div>
                </nav>
            </div>

        </div>

        <div class="flex-1 overflow-auto">


    
<div class="bg-[#4D44B5] text-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold">Questions pour: {{ $quiz->title }}</h1>
            <p class="text-white opacity-80">{{ $quiz->description }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.AjouterQuiz') }}" class="bg-white text-[#4D44B5] px-4 py-2 rounded-lg font-medium hover:bg-gray-100 transition">
                <i class="fas fa-arrow-left mr-2"></i>Retour aux Quiz
            </a>
            <button onclick="document.getElementById('questionModal').classList.remove('hidden')" 
                    class="bg-white text-[#4D44B5] px-4 py-2 rounded-lg font-medium hover:bg-gray-100 transition">
                <i class="fas fa-plus mr-2"></i>Nouvelle Question
            </button>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2">
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
            <div class="flex justify-between items-center">
                <p>{{ session('success') }}</p>
                <button type="button" class="text-green-700" onclick="this.parentElement.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
@endif

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-xl shadow overflow-hidden">
        @if($questions->isEmpty())
            <div class="text-center p-12">
                <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-question text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune question disponible</h3>
                <p class="text-gray-500 mb-6">Commencez par créer votre première question pour ce quiz.</p>
                <button onclick="document.getElementById('questionModal').classList.remove('hidden')" 
                        class="bg-[#4D44B5] text-white px-6 py-2 rounded-lg font-medium hover:bg-[#3a32a1] transition">
                    <i class="fas fa-plus mr-2"></i>Créer une question
                </button>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                @foreach($questions as $question)
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden">
                    <div class="p-5">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="text-lg font-semibold text-[#4D44B5] line-clamp-2" title="{{ $question->question_text }}">
                                {{ $loop->iteration }}. {{ Str::limit($question->question_text, 50) }}
                            </h3>
                            <form action="{{ route('admin.questions', [$quiz, $question]) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700" 
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette question?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>

                        @if($question->image_path)
                            <div class="mb-3 rounded-lg overflow-hidden h-40 flex items-center justify-center bg-gray-100">
                                <img src="{{ asset('storage/'.$question->image_path) }}" 
                                     class="max-h-full max-w-full object-contain" 
                                     alt="Image de question">
                            </div>
                        @endif

                        <div class="flex items-center justify-between mb-3">
                            <span class="bg-gray-100 text-gray-800 text-xs px-2.5 py-0.5 rounded-full flex items-center">
                                <i class="fas fa-clock mr-1"></i> {{ $question->duration }}s
                            </span>
                            <span class="text-xs text-gray-500">
                                {{ count($question->choices) }} choix
                            </span>
                        </div>

                        <button onclick="showQuestionDetails('{{ $question->id }}')" 
                                class="w-full mt-2 bg-[#4D44B5] bg-opacity-10 text-[#4D44B5] hover:bg-opacity-20 px-3 py-1 rounded-lg text-sm font-medium transition">
                            Voir détails
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</main>

<div id="questionDetailsModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50 p-4">
    <div class="bg-white w-full max-w-2xl rounded-lg overflow-hidden max-h-[90vh] overflow-y-auto">
        <div class="bg-[#4D44B5] text-white px-6 py-4 flex justify-between items-center">
            <h2 class="text-xl font-bold">Détails de la question</h2>
            <button onclick="document.getElementById('questionDetailsModal').classList.add('hidden')" class="text-white hover:text-gray-200">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="p-6">
            <div>
                <h3 class="text-lg font-semibold text-[#4D44B5] mb-3">{{ $question->question_text }}</h3>
                
                @if($question->image_path)
                <div class="mb-4 flex justify-center">
                    <img src="{{ asset('storage/'.$question->image_path) }}" 
                         class="rounded-lg border border-gray-200 max-w-full h-auto max-h-48" 
                         alt="Image de question">
                </div>
                @else
                <p class="text-gray-400 mb-4">Aucune image</p>
                @endif
                
                <div class="mb-4 flex items-center justify-between">
                    <span class="bg-gray-100 text-gray-800 text-xs px-2.5 py-0.5 rounded-full flex items-center">
                        <i class="fas fa-clock mr-1"></i> {{ $question->duration }} secondes
                    </span>
                    <div class="flex space-x-3">
                        <button onclick="openEditModal('{{ $quiz->id }}', '{{ $question->id }}')" 
                                class="text-[#4D44B5] hover:text-[#3a32a1] text-sm flex items-center">
                            <i class="fas fa-edit mr-1"></i> Modifier
                        </button>
                        <form id="deleteForm{{ $question->id }}" action="{{ route('admin.questions', [$quiz, $question]) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmDelete('{{ $question->id }}')" 
                                    class="text-red-500 hover:text-red-700 text-sm flex items-center">
                                <i class="fas fa-trash mr-1"></i> Supprimer
                            </button>
                        </form>
                    </div>
                </div>
                
                <h4 class="font-medium text-gray-700 mb-2">Choix de réponses:</h4>
                <div class="space-y-2">
                    @foreach($question->choices as $index => $choice)
                    <div class="flex items-center p-3 rounded-lg {{ $choice->is_correct ? 'bg-green-50 border border-green-200' : 'bg-gray-50' }}">
                        <span class="font-medium mr-3">{{ chr(65 + $index) }}.</span>
                        <span class="{{ $choice->is_correct ? 'font-medium text-green-600' : 'text-gray-700' }}">
                            {{ $choice->choice_text }}
                        </span>
                        @if($choice->is_correct)
                        <span class="ml-auto bg-green-100 text-green-800 text-xs px-2 py-0.5 rounded-full">
                            Bonne réponse
                        </span>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>



            
<div id="questionModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50 p-4">
    <div class="bg-white w-full max-w-2xl rounded-lg overflow-hidden max-h-[90vh] overflow-y-auto">
        <div class="bg-[#4D44B5] text-white px-6 py-4">
            <h2 class="text-xl font-bold" id="modalQuestionTitle">Nouvelle Question</h2>
        </div>
        <form id="questionForm" method="POST" enctype="multipart/form-data" class="p-6"
              action="{{ isset($questionToEdit) ? route('admin.questions', [$quiz, $questionToEdit]) : route('admin.questions', $quiz) }}">
            @csrf
            @if(isset($questionToEdit))
                @method('PUT')
            @endif
            
            <div class="space-y-4">
                <div>
                    <label for="questionText" class="block text-sm font-medium text-gray-700 mb-1">Texte de la question *</label>
                    <textarea class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-[#4D44B5]" 
                              id="questionText" name="question_text" rows="3" required>{{ old('question_text', $questionToEdit->question_text ?? '') }}</textarea>
                    @error('question_text')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="questionImage" class="block text-sm font-medium text-gray-700 mb-1">Image</label>
                        <input type="file" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-[#4D44B5]" 
                               id="questionImage" name="image" accept="image/*">
                        @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        @if(isset($questionToEdit) && $questionToEdit->image_path))
                            <div class="mt-2">
                                <img src="{{ asset('storage/'.$questionToEdit->image_path) }}" 
                                     class="max-h-32 rounded-lg border border-gray-200">
                                <label class="flex items-center mt-2">
                                    <input type="checkbox" name="remove_image" class="rounded text-[#4D44B5]">
                                    <span class="ml-2 text-sm text-gray-600">Supprimer l'image</span>
                                </label>
                            </div>
                        @endif
                    </div>
                    <div>
                        <label for="questionDuration" class="block text-sm font-medium text-gray-700 mb-1">Durée (secondes) *</label>
                        <input type="number" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-[#4D44B5]" 
                               id="questionDuration" name="duration" min="5" max="300" 
                               value="{{ old('duration', $questionToEdit->duration ?? 30) }}" required>
                        @error('duration')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="pt-2">
                    <div class="flex justify-between items-center mb-3">
                        <h3 class="text-sm font-medium text-gray-700">Choix de réponse *</h3>
                        <button type="button" id="addChoiceBtn" class="text-[#4D44B5] hover:text-[#3a32a1] text-sm font-medium">
                            <i class="fas fa-plus mr-1"></i>Ajouter un choix
                        </button>
                    </div>
                    
                    <div id="choicesContainer" class="space-y-3">
                        @if(isset($questionToEdit) && $questionToEdit->choices->count() > 0)
                            @foreach($questionToEdit->choices as $index => $choice)
                            <div class="choice-item p-3 border rounded-lg">
                                <div class="flex items-center">
                                    <input type="radio" name="correct_choice" value="{{ $index }}" 
                                           class="h-4 w-4 text-[#4D44B5] border-gray-300 focus:ring-[#4D44B5]"
                                           {{ $choice->is_correct ? 'checked' : '' }}>
                                    <input type="text" name="choices[{{ $index }}][text]" 
                                           class="ml-3 flex-1 px-3 py-1 border-b focus:outline-none focus:border-[#4D44B5]" 
                                           placeholder="Texte du choix" 
                                           value="{{ old('choices.'.$index.'.text', $choice->choice_text) }}" required>
                                    <input type="hidden" name="choices[{{ $index }}][id]" value="{{ $choice->id }}">
                                    <button type="button" class="ml-2 text-gray-400 hover:text-red-500 remove-choice-btn"
                                            {{ $questionToEdit->choices->count() <= 2 ? 'disabled' : '' }}>
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        @else
                            @for($i = 0; $i < max(2, count(old('choices', []))); $i++)
                            <div class="choice-item p-3 border rounded-lg">
                                <div class="flex items-center">
                                    <input type="radio" name="correct_choice" value="{{ $i }}" 
                                           class="h-4 w-4 text-[#4D44B5] border-gray-300 focus:ring-[#4D44B5]"
                                           {{ $i === 0 ? 'checked' : '' }}>
                                    <input type="text" name="choices[{{ $i }}][text]" 
                                           class="ml-3 flex-1 px-3 py-1 border-b focus:outline-none focus:border-[#4D44B5]" 
                                           placeholder="Texte du choix" 
                                           value="{{ old('choices.'.$i.'.text', '') }}" required>
                                    <button type="button" class="ml-2 text-gray-400 hover:text-red-500 remove-choice-btn"
                                            {{ $i < 2 ? 'disabled' : '' }}>
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            @endfor
                        @endif
                    </div>
                    @error('choices')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @error('correct_choice')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" onclick="document.getElementById('questionModal').classList.add('hidden')" 
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                    Annuler
                </button>
                <button type="submit" class="px-4 py-2 bg-[#4D44B5] text-white rounded-lg hover:bg-[#3a32a1]">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

@if(session('success'))
<div id="successToast" class="fixed top-4 right-4 z-50">
    <div class="bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center">
        <i class="fas fa-check-circle mr-2"></i>
        <span>{{ session('success') }}</span>
    </div>
</div>
@endif
            <div> 
<script> 





document.addEventListener('DOMContentLoaded', function() {
        if (document.getElementById('successToast')) {
            setTimeout(() => {
                document.getElementById('successToast').remove();
            }, 3000);
        }

        document.getElementById('addChoiceBtn')?.addEventListener('click', function() {
            const container = document.getElementById('choicesContainer');
            if (container.children.length >= 5) {
                alert('Maximum 5 choix par question');
                return;
            }
            
            const index = container.children.length;
            const choiceDiv = document.createElement('div');
            choiceDiv.className = 'choice-item p-3 border rounded-lg';
            choiceDiv.innerHTML = `
                <div class="flex items-center">
                    <input type="radio" name="correct_choice" value="${index}" 
                           class="h-4 w-4 text-[#4D44B5] border-gray-300 focus:ring-[#4D44B5]">
                    <input type="text" name="choices[${index}][text]" 
                           class="ml-3 flex-1 px-3 py-1 border-b focus:outline-none focus:border-[#4D44B5]" 
                           placeholder="Texte du choix" required>
                    <button type="button" class="ml-2 text-gray-400 hover:text-red-500 remove-choice-btn"
                            ${container.children.length < 2 ? 'disabled' : ''}>
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            container.appendChild(choiceDiv);
            updateRemoveButtons();
        });
        
        document.getElementById('choicesContainer')?.addEventListener('click', function(e) {
            if (e.target.closest('.remove-choice-btn') && !e.target.closest('.remove-choice-btn').disabled) {
                const container = document.getElementById('choicesContainer');
                if (container.children.length <= 2) {
                    alert('Minimum 2 choix requis');
                    return;
                }
                
                const choiceItem = e.target.closest('.choice-item');
                const radio = choiceItem.querySelector('input[type="radio"]');
                if (radio.checked) {
                    container.querySelector('input[type="radio"]').checked = true;
                }
                
                choiceItem.remove();
                updateRemoveButtons();
            }
        });


        document.getElementById('questionImage')?.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const previewContainer = document.getElementById('imagePreviewContainer');
                    const preview = document.getElementById('imagePreview');
                    
                    if (!previewContainer) {
                        const container = document.createElement('div');
                        container.id = 'imagePreviewContainer';
                        container.className = 'mt-2';
                        
                        const img = document.createElement('img');
                        img.id = 'imagePreview';
                        img.className = 'max-h-32 rounded-lg border border-gray-200';
                        img.src = event.target.result;
                        
                        container.appendChild(img);
                        e.target.parentNode.appendChild(container);
                    } else {
                        preview.src = event.target.result;
                        previewContainer.classList.remove('hidden');
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    });

                function confirmDelete(questionId) {
                    if (confirm('Êtes-vous sûr de vouloir supprimer cette question?')) {
                        document.getElementById('deleteForm' + questionId).submit();
                    }
                }
                
                function openEditModal(quizId, questionId) {
                    document.getElementById('questionDetailsModal').classList.add('hidden');
                    
                    window.location.href = `/admin/${quizId}/questions?edit=${questionId}#questionModal`;
                }



    toggleSection("candidats-header", "candidats-list", "candidats-arrow");
    toggleSection("cours-theorique-header", "cours-theorique-list", "cours-theorique-arrow");
    toggleSection("cours-pratique-header", "cours-pratique-list", "cours-pratique-arrow");
    toggleSection("vehicule-header", "vehicule-list", "vehicule-arrow");
    toggleSection("examen-header", "examen-list", "examen-arrow");
    toggleSection("moniteurs-header", "moniteurs-list", "moniteurs-arrow");
    toggleSection("caisse-header", "caisse-list", "caisse-arrow");

  
async function logout() {
    try {
        const response = await fetch('/api/logout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('token')}`, 
            },
        });

        const data = await response.json();

        if (response.ok) {
            localStorage.removeItem('token');
            localStorage.removeItem('role');
            alert(data.message);
            window.location.href = '/connecter'; 
        } else {
            alert('Échec de la déconnexion : ' + data.message); 
        }
    } catch (error) {
        console.error('Erreur lors de la déconnexion:', error);
        alert('Une erreur est survenue. Veuillez réessayer.');
    }
}

    </script>
</body>

</html>
